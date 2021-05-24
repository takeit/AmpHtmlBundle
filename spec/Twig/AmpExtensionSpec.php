<?php

/*
 * This file is part of the takeit/AmpHtmlBundle package.
 *
 * (c) Rafał Muszyński <rmuszynski1@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Takeit\Bundle\AmpHtmlBundle\Twig;

use PhpSpec\ObjectBehavior;
use Takeit\Bundle\AmpHtmlBundle\Generator\AmpUrlGeneratorInterface;
use Takeit\Bundle\AmpHtmlBundle\Twig\AmpExtension;
use Twig\Extension\AbstractExtension;

/**
 * @mixin AmpExtension
 *
 * @author Rafał Muszyński <rmuszynski1@gmail.com>
 */
class AmpExtensionSpec extends ObjectBehavior
{
    function let(AmpUrlGeneratorInterface $ampUrlGenerator)
    {
        $this->beConstructedWith($ampUrlGenerator);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AmpExtension::class);
    }

    function it_is_a_twig_extension()
    {
        $this->shouldHaveType(AbstractExtension::class);
    }
}
