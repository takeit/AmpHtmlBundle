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

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Takeit\Bundle\AmpHtmlBundle\Checker\AmpSupportCheckerInterface;

/**
 * AMP HTML Route Loader.
 *
 * @author Rafał Muszyński <rmuszynski1@gmail.com>
 */
class AmpLoader extends Loader
{
    /**
     * @var bool
     */
    private $loaded = false;

    /**
     * @var AmpSupportCheckerInterface
     */
    private $checker;

    /**
     * @var array
     */
    private $parameters;

    /**
     * @var string
     */
    private $controller;

    /**
     * @param AmpSupportCheckerInterface $checker
     * @param array                      $parameters
     * @param string                     $controller
     */
    public function __construct(AmpSupportCheckerInterface $checker, array $parameters, $controller)
    {
        $this->checker = $checker;
        $this->parameters = $parameters;
        $this->controller = $controller;
    }

    /**
     * {@inheritdoc}
     */
    public function load($resource, $type = null)
    {
        if (true === $this->loaded) {
            throw new \RuntimeException('Do not add the "amp" loader twice');
        }

        $routes = new RouteCollection();

        if (!$this->checker->isEnabled()) {
            return $routes;
        }

        $path = sprintf('%s/{%s}', $this->parameters['prefix'], $this->parameters['parameter']);
        if (isset($this->parameters['pattern']) && null !== $this->parameters['pattern']) {
            $path = sprintf(
                '/%s/%s/{%s}',
                ltrim($this->parameters['prefix'], '/'),
                $this->parameters['pattern'],
                $this->parameters['parameter']
            );
        }

        $defaults = array(
            '_controller' => $this->controller,
            '_amp_route' => true,
        );

        $requirements = array(
            $this->parameters['parameter'] => $this->parameters['parameterRegex'],
        );

        $routes->add('takeit_amp_html_view', new Route($path, $defaults, $requirements));
        $this->loaded = true;

        return $routes;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($resource, $type = null)
    {
        return is_string($resource) && 'amp' === $type;
    }
}
