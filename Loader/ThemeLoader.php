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

final class ThemeLoader implements ThemeLoaderInterface
{
    /**
     * @var \Twig_Loader_Filesystem
     */
    private $filesystem;

    /**
     * @var string
     */
    private $themePath;

    /**
     * @param \Twig_Loader_Filesystem $filesystem
     * @param $themePath
     */
    public function __construct(\Twig_Loader_Filesystem $filesystem, $themePath)
    {
        $this->filesystem = $filesystem;
        $this->themePath = $themePath;
    }

    /**
     * {@inheritdoc}
     */
    public function load()
    {
        $this->filesystem->addPath($this->themePath, ThemeLoaderInterface::NAMESPACE);
    }
}
