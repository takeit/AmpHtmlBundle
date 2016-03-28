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
     * @var string
     */
    private $themeName;

    /**
     * @param \Twig_environment $twig
     * @param string            $themeName
     */
    public function __construct(\Twig_environment $twig, $themeName)
    {
        $this->twig = $twig;
        $this->themeName = $themeName;
    }

    /**
     * @param AmpInterface $object
     *
     * @return Response
     */
    public function viewAction(AmpInterface $object)
    {
        $response = new Response();
        $response->setContent($this->twig->render(sprintf('@amp_themes/%s/index.html.twig', $this->themeName), [
            'object' => $object,
        ]));

        return $response;
    }
}
