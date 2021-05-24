<?php

/*
 * This file is part of the takeit/AmpHtmlBundle package.
 *
 * (c) Rafał Muszyński <rmuszynski1@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Takeit\Bundle\AmpHtmlBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * @author Rafał Muszyński <rmuszynski1@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('takeit_amp_html');
        $treeBuilder->getRootNode()
            ->canBeDisabled()
                ->info('Enable or disable Google AMP HTML support.')
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('theme')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('loader')
                            ->defaultValue('takeit_amp_html.loader.theme.default')
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('theme_path')
                            ->defaultValue('%kernel.root_dir%/Resources/amp/amp-theme')
                        ->end()
                    ->end()
                ->end()
                ->scalarNode('checker')
                    ->defaultValue('takeit_amp_html.checker.default')
                    ->cannotBeEmpty()
                ->end()
                ->arrayNode('routing')
                    ->isRequired()
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('route_strategy')
                            ->canBeEnabled()
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('prefix')
                                    ->defaultValue('/platform/amp')
                                ->end()
                                ->scalarNode('pattern')
                                    ->isRequired()
                                    ->cannotBeEmpty()
                                ->end()
                                    ->scalarNode('parameter')
                                    ->cannotBeEmpty()
                                    ->defaultValue('slug')
                                ->end()
                                ->scalarNode('parameterRegex')
                                    ->defaultValue('.+')
                                    ->info('Parameter\'s regular expression.')
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('parameter_strategy')
                            ->canBeEnabled()
                        ->end()
                        ->scalarNode('controller')
                            ->defaultValue('takeit_amp_html.amp_controller:viewAction')
                        ->end()
                    ->end()
                ->end()
                ->scalarNode('model')
                    ->cannotBeEmpty()
                    ->isRequired()
                    ->info('Fully qualified class name of your model.')
                ->end()
                ->scalarNode('converter')
                    ->defaultValue('takeit_amp_html.amp_converter')
                    ->info('Custom converter service id.')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
