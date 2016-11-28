<?php

/*
 * This file is part of the takeit/AmpHtmlBundle package.
 *
 * (c) Rafał Muszyński <rmuszynski1@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Takeit\Bundle\AmpHtmlBundle\Controller;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Response;
use Takeit\Bundle\AmpHtmlBundle\Controller\AmpViewController;
use Takeit\Bundle\AmpHtmlBundle\Converter\AmpConverterInterface;
use Takeit\Bundle\AmpHtmlBundle\Model\AmpInterface;

/**
 * @mixin AmpViewController
 *
 * @author Rafał Muszyński <rmuszynski1@gmail.com>
 */
class AmpViewControllerSpec extends ObjectBehavior
{
    function let(\Twig_Environment $twig, AmpConverterInterface $converter)
    {
        $this->beConstructedWith($twig, $converter);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AmpViewController::class);
    }
    
    function it_should_render_amp_template(AmpInterface $ampObject, $twig, AmpConverterInterface $converter)
    {
        $converter->convertToAmp('<html><body>test html</body></html>')->willReturn('amp converter html');
        $twig->render(Argument::exact('@amp_theme/index.html.twig'), [
            'object' => $ampObject,
        ])->willReturn('<html><body>test html</body></html>');

        $response = $this->viewAction($ampObject);
        $response->shouldBeAnInstanceOf(Response::class);
        $response->getContent()->shouldBe('amp converter html');
    }
}
