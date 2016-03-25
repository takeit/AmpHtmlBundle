<?php

/*
 * This file is part of the takeit/AmpHtmlBundle package.
 *
 * (c) Rafał Muszyński <rmuszynski1@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Takeit\Bundle\AmpHtmlBundle\Converter;

/**
 * AmpConverterInterface converts HTML to AMP HTML format.
 *
 * @author Rafał Muszyński <rmuszynski1@gmail.com>
 */
interface AmpConverterInterface
{
    /**
     * Converts HTML to AMP HTML.
     *
     * @param $html HTML string
     *
     * @return string
     */
    public function convertToAmp($html);
}
