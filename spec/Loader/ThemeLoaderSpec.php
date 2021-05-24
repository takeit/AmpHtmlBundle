<?php

/*
 * This file is part of the takeit/AmpHtmlBundle package.
 *
 * (c) Rafał Muszyński <rmuszynski1@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Takeit\Bundle\AmpHtmlBundle\Loader;

use PhpSpec\ObjectBehavior;
use Takeit\Bundle\AmpHtmlBundle\Loader\ThemeLoader;
use Takeit\Bundle\AmpHtmlBundle\Loader\ThemeLoaderInterface;
use Twig\Loader\FilesystemLoader;

/**
 * @mixin ThemeLoader
 */
final class ThemeLoaderSpec extends ObjectBehavior
{
    public function let(FilesystemLoader $filesystem)
    {
        $this->beConstructedWith($filesystem, '/path/to/amp/amp-theme');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ThemeLoader::class);
    }

    public function it_implements_interface()
    {
        $this->shouldImplement(ThemeLoaderInterface::class);
    }

    public function it_loads_amp_theme(FilesystemLoader $filesystem)
    {
        $filesystem->addPath('/path/to/amp/amp-theme', 'amp_theme')->shouldBeCalled();

        $this->load();
    }
}
