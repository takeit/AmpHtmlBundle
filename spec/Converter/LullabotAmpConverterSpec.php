<?php

/*
 * This file is part of the takeit/AmpHtmlBundle package.
 *
 * (c) Rafał Muszyński <rmuszynski1@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Takeit\Bundle\AmpHtmlBundle\Converter;

use Lullabot\AMP\AMP;
use Lullabot\AMP\Validate\Scope;
use PhpSpec\ObjectBehavior;
use Takeit\Bundle\AmpHtmlBundle\Converter\LullabotAmpConverter;

/**
 * @mixin LullabotAmpConverter
 *
 * @author Rafał Muszyński <rmuszynski1@gmail.com>
 */
class LullabotAmpConverterSpec extends ObjectBehavior
{
    function let(AMP $amp)
    {
        $this->beConstructedWith($amp);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(LullabotAmpConverter::class);
    }

    function it_should_convert_html_to_amp_html($amp)
    {
        $amp->loadHtml('html', ['scope' => Scope::HTML_SCOPE])->shouldBeCalled();
        $amp->convertToAmpHtml()->shouldBeCalled()->willReturn('amp-ified html');

        $this->convertToAmp('html')->shouldReturn('amp-ified html');
    }
}
