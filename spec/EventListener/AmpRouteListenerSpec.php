<?php

/*
 * This file is part of the takeit/AmpHtmlBundle package.
 *
 * (c) Rafał Muszyński <rmuszynski1@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Takeit\Bundle\AmpHtmlBundle\EventListener;

use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Takeit\Bundle\AmpHtmlBundle\EventListener\AmpRouteListener;

/**
 * @mixin AmpRouteListener.
 *
 * @author Rafał Muszyński <rmuszynski1@gmail.com>
 */
final class AmpRouteListenerSpec extends ObjectBehavior
{
    function let(ControllerResolverInterface $controllerResolver)
    {
        $this->beConstructedWith($controllerResolver, ['controller' => 'controller:method']);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AmpRouteListener::class);
    }

    function it_does_nothing_when_no_amp_param(
        FilterControllerEvent $event,
        Request $request,
        ParameterBag $parameterBag
    ) {
        $parameterBag->has('amp')->shouldBeCalled()->willReturn(false);
        $request->query = $parameterBag;
        $event->getRequest()->willReturn($request);

        $this->onKernelController($event);
    }
}
