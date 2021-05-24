<?php

/*
 * This file is part of the takeit/AmpHtmlBundle package.
 *
 * (c) Rafał Muszyński <rmuszynski1@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Takeit\Bundle\AmpHtmlBundle\Loader;

use Twig\Loader\FilesystemLoader;

final class ThemeLoader implements ThemeLoaderInterface
{
    /**
     * @var FilesystemLoader
     */
    private $filesystem;

    /**
     * @var string
     */
    private $themePath;

    /**
     * @param FilesystemLoader $filesystem
     * @param $themePath
     */
    public function __construct(FilesystemLoader $filesystem, $themePath)
    {
        $this->filesystem = $filesystem;
        $this->themePath = $themePath;
    }

    /**
     * {@inheritdoc}
     */
    public function load()
    {
        $this->filesystem->addPath($this->themePath, ThemeLoaderInterface::THEME_NAMESPACE);
    }
}
