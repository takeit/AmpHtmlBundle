<?php

/*
 * This file is part of the takeit/AmpHtmlBundle package.
 *
 * (c) Rafał Muszyński <rmuszynski1@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Takeit\Bundle\AmpHtmlBundle\Generator;

interface AmpUrlGeneratorInterface
{
    /**
     * @param string $url
     *
     * @return string
     */
    public function generate($url);
}
