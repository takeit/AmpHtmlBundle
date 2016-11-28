<?php

/*
 * This file is part of the takeit/AmpHtmlBundle package.
 *
 * (c) Rafał Muszyński <rmuszynski1@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Takeit\Bundle\AmpHtmlBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * AddTwigPathsPass adds custom Twig Loader paths.
 *
 * @author Rafał Muszyński <rmuszynski1@gmail.com>
 */
class AddTwigPathsPass implements CompilerPassInterface
{
    /**
     * AMP themes namespace.
     *
     * @var string
     */
    const NAMESPACE_AMP_THEMES = 'amp_themes';

    /**
     * Current AMP theme's namespace.
     *
     * @var string
     */
    const NAMESPACE_AMP_THEME = 'amp_theme';

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->getParameter('takeit_amp_html.configuration.enabled')) {
            return;
        }

        $bundles = $container->getParameter('kernel.bundles');
        if (!isset($bundles['TwigBundle'])) {
            throw new \RuntimeException(
                'TwigBundle is not registered!'
            );
        }

        $loader = $container->getDefinition('twig.loader.filesystem');
        $loader->addMethodCall('addPath', [
            $container->getParameter('takeit_amp_html.configuration.theme.themes_path'),
            self::NAMESPACE_AMP_THEMES,
        ]);

        $loader->addMethodCall('addPath', [
            $container->getParameter('takeit_amp_html.configuration.theme.theme_path'),
            self::NAMESPACE_AMP_THEME,
        ]);
    }
}
