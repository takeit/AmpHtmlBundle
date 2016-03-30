<?php

/*
 * This file is part of the takeit/AmpHtmlBundle package.
 *
 * (c) Rafał Muszyński <rmuszynski1@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Takeit\Bundle\AmpHtmlBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Takeit\Bundle\AmpHtmlBundle\DependencyInjection\Compiler\AddTwigPathsPass;

/**
 * Class TakeitAmpHtmlBundle.
 *
 * @author Rafał Muszyński <rmuszynski1@gmail.com>
 */
class TakeitAmpHtmlBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new AddTwigPathsPass());
    }
}
