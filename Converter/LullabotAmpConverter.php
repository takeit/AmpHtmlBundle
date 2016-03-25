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

use Lullabot\AMP\Validate\Scope;
use Lullabot\AMP\AMP;

/**
 * HTML to AMP HTML converter.
 *
 * @author Rafał Muszyński <rmuszynski1@gmail.com>
 */
class LullabotAmpConverter implements AmpConverterInterface
{
    /**
     * @var AMP
     */
    private $ampConverter;

    /**
     * @param AMP $ampConverter
     */
    public function __construct(AMP $ampConverter)
    {
        $this->ampConverter = $ampConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function convertToAmp($html)
    {
        $this->ampConverter->loadHtml($html, ['scope' => Scope::HTML_SCOPE]);

        return $this->ampConverter->convertToAmpHtml();
    }
}
