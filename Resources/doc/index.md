TakeitAmpHtmlBundle
===================

This bundle aims to provide [AMP HTML](https://www.ampproject.org) conversion to your Symfony2/Symfony3 projects. Based on [Lullabot/amp-library](https://github.com/Lullabot/amp-library).

Installation
------------

### Step 1: Download the Bundle using Composer

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require takeit/amp-html-bundle
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Step 2: Enable the Bundle

Then, enable the bundle by adding the following line in the `app/AppKernel.php`
file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Takeit\Bundle\AmpHtmlBundle\TakeitAmpHtmlBundle(),
        );
        
        // ...
    }
}
```

### Step 3: Configure the Bundle

In order to use this bundle, some configuration is required.

- provide `model` fully qualified class name, the class which should be AMP-ified.
- choose the strategy on how the AMP HTML should be handled 

#### Route Strategy:

Route strategy lets you handle AMP HTML via separate route designed to handle AMP-ified content.

For example, if your articles are accessible under `/pl/blog/posts/nulla-porta-lobortis-ligula-vel-egestas` route,
you need to specify the following pattern: e.g.`{_locale}/{controller}/{action}`.

In this case AMP HTML version of your article will be accessible using:
`/platform/amp/pl/blog/posts/nulla-porta-lobortis-ligula-vel-egestas` URL.

 > **Note:**
 > By default, the articles are searchable via slug. 
 > Although, this behaviour can be changed depending on your class implementation,
 > see Configuration Reference for more details.

The example configuration should look like below:

```yml
# app/config/config*.yml
takeit_amp_html:
    model: AppBundle\Entity\Post
    routing:
        route_strategy:
            pattern: "{_locale}/{controller}/{action}"
```

#### Parameter Strategy:

This strategy doesn't add any new route to handle AMP HTML version of your articles/posts. Instead, it uses `amp` query parameter to determine whether to load article in AMP HTML format or not.

For example, if your articles are accessible under `/pl/blog/posts/nulla-porta-lobortis-ligula-vel-egestas` route, your AMP HTML version can be found by adding `?amp` parameter to the URL: `/pl/blog/posts/nulla-porta-lobortis-ligula-vel-egestas?amp`.

`/pl/blog/posts/nulla-porta-lobortis-ligula-vel-egestas?param=1&amp` will also work fine.

To make use of Parameter Strategy, use this configuration:

```yml
# app/config/config*.yml
takeit_amp_html:
    theme:
        current_theme: "amp-theme"
    model: AppBundle\Entity\Post
    routing:
        parameter_strategy:
            enabled: true
```

### Step 4: Implement AmpInterface

In order to convert your articles to AMP HTML format, your model's class needs to implement `AmpInterface`.

```php
<?php
// src/AppBundle/EntityPost.php

namespace AppBundle\Entity;

use Takeit\Bundle\AmpHtmlBundle\Model\AmpInterface;
// ...

class Post implements AmpInterface 
{
    // ...
}
```

### Step 5: Download and install the demo theme.

Create a new directory `app/Resources/amp/`, download the [demo theme](https://github.com/takeit/amp-theme) and copy it into the newly created directory, name its folder: `amp-theme`.

### Step 6: That's it!

Go to, for example. http://example.com/platform/amp/pl/blog/posts/nulla-porta-lobortis-ligula-vel-egestas
and see your AMP HTML page!

Twig extension
--------------

To generate URL to an article (based on configured strategy) in AMP HTML format from Twig, just use `amp` Twig filter provided by this bundle:

```twig
{{ path(article)|amp }}
```

Theme Loader
------------

Theme loader is used to load theme from different sources. By default Twig filesystem loader is used which loads templates from configured directory.

By default, if `theme_path` is provided under `theme` node in bundle's config, it will load it directly from that directory.

You have the possibility to provide your own loader service in bundle's config if you wish to have custom logic. For example, it can be useful if you want to load theme from directory which changed dynamically based on current business logic.

AMP HTML Support Checker
------------------------

This service is used to check whether AMP HTML support should be enabled or disabled. By default it is enabled. You may need to have the possibility to disable or enable AMP HTML support dynamically using API etc. This service helps you to easily manage that.

Reference Configuration
-----------------------

``` yaml
# app/config/config*.yml
takeit_amp_html:
    theme:
        loader: 'takeit_amp_html.loader.theme.default'
        theme_path: "%kernel.root_dir%/Resources/amp/themes/amp-theme"
    model: AppBundle\Entity\Post
    checker: 'takeit_amp_html.checker.default'
    routing:
        controller: "takeit_amp_html.amp_controller:viewAction"
        route_strategy:
            pattern: "{_locale}/{controller}/{action}"
            prefix: "/platform/amp"
            parameter: "slug"
            parameterRegex: ".+"
         parameter_strategy:
            enabled: true
```
