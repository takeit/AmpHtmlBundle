<?php

/*
 * This file is part of the takeit/AmpHtmlBundle package.
 *
 * (c) Rafał Muszyński <rmuszynski1@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Takeit\Bundle\AmpHtmlBundle\Generator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Takeit\Bundle\AmpHtmlBundle\Generator\AmpUrlGeneratorInterface;
use Takeit\Bundle\AmpHtmlBundle\Generator\ParameterUrlGenerator;

/**
 * @mixin ParameterUrlGenerator
 *
 * @author Rafał Muszyński <rmuszynski1@gmail.com>
 */
class ParameterUrlGeneratorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ParameterUrlGenerator::class);
    }

    function it_implements_interface()
    {
        $this->shouldImplement(AmpUrlGeneratorInterface::class);
    }

    function it_generates_url()
    {
        $this->generate('/test/article?param=1')->shouldReturn('/test/article?param=1&amp');
        $this->generate('/test/article')->shouldReturn('/test/article?amp');
    }
}
