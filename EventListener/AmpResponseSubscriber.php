<?php

/*
 * This file is part of the takeit/AmpHtmlBundle package.
 *
 * (c) Rafał Muszyński <rmuszynski1@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Takeit\Bundle\AmpHtmlBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Takeit\Bundle\AmpHtmlBundle\Converter\AmpConverterInterface;

/**
 * Event subscriber to handle AMP responses.
 *
 * @author Rafał Muszyński <rmuszynski1@gmail.com>
 */
class AmpResponseSubscriber implements EventSubscriberInterface
{
    /**
     * @var AmpConverterInterface
     */
    private $converter;

    /**
     * @param AmpConverterInterface $converter
     */
    public function __construct(AmpConverterInterface $converter)
    {
        $this->converter = $converter;
    }

    /**
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();
        $request = $event->getRequest();
        if ($request->isXmlHttpRequest() || !$request->attributes->get('_amp_route')) {
            return;
        }

        $event->setResponse($this->convertToAmp($response));
    }

    /**
     * @param Response $response
     *
     * @return Response
     *
     * @throws \Exception
     */
    protected function convertToAmp(Response $response)
    {
        $ampHtml = $this->converter->convertToAmp($response->getContent());
        $response->setContent($ampHtml);

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::RESPONSE => [
                ['onKernelResponse', 30],
            ],
        ];
    }
}
