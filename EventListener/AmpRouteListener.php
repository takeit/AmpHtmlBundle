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

use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

final class AmpRouteListener
{
    /**
     * @var ControllerResolverInterface
     */
    private $controllerResolver;

    /**
     * @var string
     */
    private $controller;

    /**
     * AmpRouteListener constructor.
     *
     * @param ControllerResolverInterface $controllerResolver
     * @param string                      $controller
     */
    public function __construct(ControllerResolverInterface $controllerResolver, $controller)
    {
        $this->controllerResolver = $controllerResolver;
        $this->controller = $controller;
    }

    /**
     * @param FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $request = $event->getRequest();

        if ($request->query->has('amp')) {
            $request->attributes->set('_controller', $this->controller);
            $event->setController($this->controllerResolver->getController($request));
        }
    }
}
