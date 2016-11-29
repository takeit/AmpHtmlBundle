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
use Takeit\Bundle\AmpHtmlBundle\Checker\AmpSupportCheckerInterface;

final class AmpRouteListener
{
    /**
     * @var AmpSupportCheckerInterface
     */
    private $checker;

    /**
     * @var ControllerResolverInterface
     */
    private $controllerResolver;

    /**
     * @var array
     */
    private $controller;

    /**
     * AmpRouteListener constructor.
     *
     * @param AmpSupportCheckerInterface  $checker
     * @param ControllerResolverInterface $controllerResolver
     * @param $controller
     */
    public function __construct(
        AmpSupportCheckerInterface $checker,
        ControllerResolverInterface $controllerResolver,
        $controller
    ) {
        $this->checker = $checker;
        $this->controllerResolver = $controllerResolver;
        $this->controller = $controller;
    }

    /**
     * @param FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $request = $event->getRequest();

        if ($request->query->has('amp') && !$request->isXmlHttpRequest() && $this->checker->isEnabled()) {
            $request->attributes->set('_controller', $this->controller);
            $controller = $this->controllerResolver->getController($request);
            if (!$controller) {
                throw new \LogicException('Controller can not be determined!');
            }

            $event->setController($controller);
        }
    }
}
