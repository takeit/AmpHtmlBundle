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
use Takeit\Bundle\AmpHtmlBundle\Converter\AmpConverterInterface;
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
     * @var AmpConverterInterface
     */
    private $converter;

    /**
     * @param \Twig_environment     $twig
     * @param AmpConverterInterface $converter
     */
    public function __construct(\Twig_environment $twig, AmpConverterInterface $converter)
    {
        $this->twig = $twig;
        $this->converter = $converter;
    }

    /**
     * @param AmpInterface $object
     *
     * @return Response
     */
    public function viewAction(AmpInterface $object)
    {
        $response = new Response();
        $content = $this->twig->render('@amp_theme/index.html.twig', [
            'object' => $object,
        ]);

        $response->setContent($this->converter->convertToAmp($content));

        return $response;
    }
}
