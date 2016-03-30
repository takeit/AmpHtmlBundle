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

### Step 3: Enable routing

To be able to generate AMP HTML view under the specific route, 
the routing configuration needs to be provided:

```yml
# app/config/routing.yml
takeit_amphtml:
    resource: .
    type: amp
```

### Step 4: Configure the Bundle

In order to use this bundle, some configuration is required.

- provide `current_theme` name, the name of your theme for AMP HTML format.
- provide `model` fully qualified class name, the class which should be AMP-ified.
- specify route pattern, depending on your current routing.

For example, if your articles are accessible under `/pl/blog/posts/nulla-porta-lobortis-ligula-vel-egestas` route,
you need to specify the following pattern: e.g.`{_locale}/{controller}/{action}`.

 > **Note:**
 > By default, the articles are searchable via slug. 
 > Although, this behaviour can be changed depending on your class implementation,
 > see Configuration Reference for more details.

The example configuration should look like below:

```yml
# app/config/config*.yml
takeit_amp_html:
    theme:
        current_theme: "amp-theme"
    model: AppBundle\Entity\Post
    routing:
        pattern: "{_locale}/{controller}/{action}"
```

### Step 5: Implement AmpInterface

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

### Step 6: Download and install the demo theme.

Create a new directory `app/Resources/amp/`, download the [demo theme](https://github.com/takeit/amp-theme) and copy it into the newly created directory, name its folder: `amp-theme`.

### Step 7: That's it!

Go to, for example. http://example.com/platform/amp/pl/blog/posts/nulla-porta-lobortis-ligula-vel-egestas
and see your AMP HTML page!

Reference Configuration
-----------------------

``` yaml
# app/config/config*.yml
takeit_amp_html:
    theme:
        path: "%kernel.root_dir%/Resources/amp/themes"
        current_theme: "amp-theme"
    model: AppBundle\Entity\Post
    routing:
        pattern: "{_locale}/{controller}/{action}"
        controller: "takeit_amp_html.amp_controller:viewAction"
        prefix: "/platform/amp"
        parameter: "slug"
        parameterRegex: ".+"
```
