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
        $treeBuilder = new TreeBuilder();
        $treeBuilder->root('takeit_amp_html')
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('theme')
                    ->isRequired()
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('themes_path')
                            ->defaultValue('%kernel.root_dir%/Resources/amp')
                        ->end()
                        ->scalarNode('current_theme')
                            ->cannotBeEmpty()
                            ->isRequired()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('routing')
                    ->isRequired()
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('controller')
                            ->defaultValue('takeit_amp_html.amp_controller:viewAction')
                        ->end()
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
