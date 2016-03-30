<?php

/*
 * This file is part of the takeit/AmpHtmlBundle package.
 *
 * (c) Rafał Muszyński <rmuszynski1@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Takeit\Bundle\AmpHtmlBundle\DependencyInjection\Compiler;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Takeit\Bundle\AmpHtmlBundle\DependencyInjection\Compiler\AddTwigPathsPass;

/**
 * @mixin AddTwigPathsPass.
 *
 * @author Rafał Muszyński <rmuszynski1@gmail.com>
 */
class AddTwigPathsPassSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AddTwigPathsPass::class);
    }

    function it_is_compiler_pass()
    {
        $this->shouldImplement(CompilerPassInterface::class);
    }

    function it_processes(ContainerBuilder $container, Definition $coordinator)
    {
        $container->getParameter('kernel.bundles')->willReturn(['TwigBundle' => true]);
        $container->getDefinition('twig.loader.filesystem')->shouldBeCalled()->willreturn($coordinator);
        $container->getParameter('takeit_amp_html.configuration.theme.themes_path')
            ->shouldBeCalled()
            ->willReturn('/amp/themes/path');

        $container->getParameter('takeit_amp_html.configuration.theme.theme_path')
            ->shouldBeCalled()
            ->willReturn('/amp/themes/path/theme');

        $coordinator->addMethodCall('addPath', Argument::type('array'))->shouldBeCalled();

        $this->process($container);
    }

    function it_should_not_process(ContainerBuilder $container)
    {
        $container->getParameter('kernel.bundles')->willReturn([]);

        $this->shouldThrow('\RuntimeException')->duringProcess($container);
    }
}
