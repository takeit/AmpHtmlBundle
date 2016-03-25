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
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Takeit\Bundle\AmpHtmlBundle\Converter\AmpConverterInterface;
use Takeit\Bundle\AmpHtmlBundle\EventListener\AmpResponseSubscriber;

/**
 * @mixin AmpResponseSubscriber
 *
 * @author Rafał Muszyński <rmuszynski1@gmail.com>
 */
class AmpResponseSubscriberSpec extends ObjectBehavior
{
    function let(AmpConverterInterface $converter)
    {
        $this->beConstructedWith($converter);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AmpResponseSubscriber::class);
    }

    function it_is_a_subscriber()
    {
        $this->shouldImplement(EventSubscriberInterface::class);
    }

    function it_subscribes_to_an_event()
    {
        $this::getSubscribedEvents()->shouldReturn([
            KernelEvents::RESPONSE => [['onKernelResponse', 30]],
        ]);
    }

    function it_runs_only_for_amp_routes(
        FilterResponseEvent $event,
        Request $request,
        ParameterBag $attributes,
        Response $response,
        AmpConverterInterface $converter
    ) {
        $attributes->get('_amp_route')->willReturn(true);
        $request->attributes = $attributes;
        $request->isXmlHttpRequest()->willReturn(false);

        $response->getContent()->shouldBeCalled()->willReturn('html content');
        $event->getRequest()->willReturn($request);
        $event->getResponse()->willReturn($response);

        $converter->convertToAmp('html content')->willReturn('amp html content');

        $response->setContent('amp html content')->shouldBeCalled();
        $event->setResponse($response)->shouldBeCalled();

        $this->onKernelResponse($event);
    }

    function it_should_not_run_on_xml_http_requests(
        FilterResponseEvent $event,
        Request $request,
        ParameterBag $attributes,
        Response $response,
        AmpConverterInterface $converter
    ) {
        $attributes->get('_amp_route')->willReturn(true);
        $request->attributes = $attributes;
        $request->isXmlHttpRequest()->willReturn(true);

        $event->getRequest()->willReturn($request);
        $event->getResponse()->willReturn($response);

        $converter->convertToAmp(Argument::type('string'))->shouldNotBeCalled();

        $this->onKernelResponse($event)->shouldReturn(null);
    }

    function it_should_not_run_when_route_is_not_amp(
        FilterResponseEvent $event,
        Request $request,
        ParameterBag $attributes,
        Response $response,
        AmpConverterInterface $converter
    ) {
        $attributes->get('_amp_route')->willReturn(false);
        $request->attributes = $attributes;
        $request->isXmlHttpRequest()->willReturn(false);

        $event->getRequest()->willReturn($request);
        $event->getResponse()->willReturn($response);

        $converter->convertToAmp(Argument::type('string'))->shouldNotBeCalled();

        $this->onKernelResponse($event)->shouldReturn(null);
    }
}
