<?php

/*
 * This file is part of the takeit/AmpHtmlBundle package.
 *
 * (c) Rafał Muszyński <rmuszynski1@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Takeit\Bundle\AmpHtmlBundle\Routing\Loader;

use PhpSpec\ObjectBehavior;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Takeit\Bundle\AmpHtmlBundle\Checker\AmpSupportCheckerInterface;
use Takeit\Bundle\AmpHtmlBundle\Routing\Loader\AmpLoader;

/**
 * @mixin AmpLoader
 *
 * @author Rafał Muszyński <rmuszynski1@gmail.com>
 */
class AmpLoaderSpec extends ObjectBehavior
{
    private $parameters;

    function let(AmpSupportCheckerInterface $checker)
    {
        $this->parameters = [
            'pattern' => '{some}/{pattern}',
            'prefix' => '/some/prefix',
            'parameter' => 'slug',
            'parameterRegex' => '.+'
        ];

        $this->beConstructedWith($checker, $this->parameters, 'controller_service_id');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AmpLoader::class);
    }

    function it_should_load_a_resource(AmpSupportCheckerInterface $checker)
    {
        $checker->isEnabled()->willReturn(true);
        $routes = $this->getRoutes();

        $this->load('resource', 'type')->shouldBeLike($routes);
    }

    function it_should_load_a_resource_without_pattern(AmpSupportCheckerInterface $checker)
    {
        unset($this->parameters['pattern']);
        $this->beConstructedWith($checker, $this->parameters, 'controller_service_id');

        $checker->isEnabled()->willReturn(true);

        $defaults = [
            '_controller' => 'controller_service_id',
            '_amp_route' => true,
        ];

        $requirements = [
            'slug' => '.+'
        ];

        $routes = new RouteCollection();
        $route = new Route('/some/prefix/{slug}', $defaults, $requirements);
        $routes->add('takeit_amp_html_view', $route);

        $this->load('resource', 'type')->shouldBeLike($routes);
    }

    function it_should_throw_an_exception_when_loading_loader_twice(AmpSupportCheckerInterface $checker)
    {
        $routes = $this->getRoutes();
        $checker->isEnabled()->willReturn(true);

        $this->load('resource', 'type')->shouldBeLike($routes);

        $this->shouldThrow('\RuntimeException')->duringLoad('resource', 'type');
    }

    function it_should_support_only_amp_type()
    {
        $this->supports('.', 'amp')->shouldReturn(true);
    }

    function it_should_not_support_other_types()
    {
        $this->supports('.', 'fake')->shouldReturn(false);
        $this->supports(null, 'fake')->shouldReturn(false);
        $this->supports(null, 'amp')->shouldReturn(false);
    }

    private function getRoutes()
    {
        $defaults = [
            '_controller' => 'controller_service_id',
            '_amp_route' => true,
        ];

        $requirements = [
            'slug' => '.+'
        ];

        $routes = new RouteCollection();
        $route = new Route('/some/prefix/{some}/{pattern}/{slug}', $defaults, $requirements);
        $routes->add('takeit_amp_html_view', $route);

        return $routes;
    }
}
