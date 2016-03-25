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

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @author Rafał Muszyński <rmuszynski1@gmail.com>
 */
class TakeitAmpHtmlExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $container->setAlias('takeit_amp_html.converter.amp', $config['converter']);
        $loader->load('converters.yml');
        $loader->load('services.yml');

        foreach ($config['theme'] as $key => $value) {
            $container->setParameter(
                $this->getAlias().'.configuration.theme.'.$key,
                $value
            );
        }

        $container->setParameter($this->getAlias().'.configuration.model.class', $config['model']);
        $container->setParameter($this->getAlias().'.configuration.routing', $config['routing']);
    }
}
