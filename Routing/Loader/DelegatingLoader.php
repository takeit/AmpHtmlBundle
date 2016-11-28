<?php

/*
 * This file is part of the takeit/AmpHtmlBundle package.
 *
 * (c) Rafał Muszyński <rmuszynski1@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Takeit\Bundle\AmpHtmlBundle\Routing\Loader;

use Symfony\Bundle\FrameworkBundle\Routing\DelegatingLoader as BaseLoader;
use Symfony\Component\Routing\RouteCollection;

/**
 * DelegatingLoader extends default Symfony Framework Bundle Loader.
 * It is extended to load AMP HTML route. By using this loader there is no
 * need to require AmpLoader config in routing.yml file.
 */
class DelegatingLoader extends BaseLoader
{
    /**
     * {@inheritdoc}
     */
    public function load($resource, $type = null)
    {
        /** @var RouteCollection $collection */
        $collection = parent::load($resource, $type);
        $ampCollection = parent::load('.', 'amp');
        $collection->addCollection($ampCollection);

        return $collection;
    }
}
