<?php

/*
 * This file is part of the takeit/AmpHtmlBundle package.
 *
 * (c) Rafał Muszyński <rmuszynski1@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Takeit\Bundle\AmpHtmlBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Takeit\Bundle\AmpHtmlBundle\Model\AmpInterface;

/**
 * Renders AMP HTML compatible template.
 *
 * @author Rafał Muszyński <rmuszynski1@gmail.com>
 */
class AmpViewController
{
    /**
     * @var \Twig_environment
     */
    private $twig;

    /**
     * @param \Twig_environment $twig
     */
    public function __construct(\Twig_environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param AmpInterface $object
     *
     * @return Response
     */
    public function viewAction(AmpInterface $object)
    {
        $response = new Response();
        $response->setContent($this->twig->render(sprintf('@amp_theme/index.html.twig'), [
            'object' => $object,
        ]));

        return $response;
    }
}
