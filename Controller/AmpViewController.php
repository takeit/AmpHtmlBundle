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
use Takeit\Bundle\AmpHtmlBundle\Loader\ThemeLoaderInterface;
use Takeit\Bundle\AmpHtmlBundle\Model\AmpInterface;
use Twig\Environment;

/**
 * Renders AMP HTML compatible template.
 *
 * @author Rafał Muszyński <rmuszynski1@gmail.com>
 */
class AmpViewController
{
    /**
     * @var Environment;
     */
    private $twig;

    /**
     * @var AmpConverterInterface
     */
    private $converter;

    /**
     * @var ThemeLoaderInterface
     */
    private $themeLoader;

    /**
     * @param Environment     $twig
     * @param AmpConverterInterface $converter
     * @param ThemeLoaderInterface  $themeLoader
     */
    public function __construct(
        Environment $twig,
        AmpConverterInterface $converter,
        ThemeLoaderInterface $themeLoader
    ) {
        $this->twig = $twig;
        $this->converter = $converter;
        $this->themeLoader = $themeLoader;
    }

    /**
     * @param AmpInterface $object
     *
     * @return Response
     */
    public function viewAction(AmpInterface $object)
    {
        $this->themeLoader->load();

        $response = new Response();
        $content = $this->twig->render(sprintf('@%s/index.html.twig', ThemeLoaderInterface::THEME_NAMESPACE), [
            'object' => $object,
        ]);

        $response->setContent($this->converter->convertToAmp($content));

        return $response;
    }
}
