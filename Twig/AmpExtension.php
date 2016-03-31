<?php

/*
 * This file is part of the takeit/AmpHtmlBundle package.
 *
 * (c) Rafał Muszyński <rmuszynski1@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Takeit\Bundle\AmpHtmlBundle\Twig;

/**
 * AMP Twig Extension.
 */
class AmpExtension extends \Twig_Extension
{
    /**
     * @var array
     */
    private $config;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('amp_path', array($this, 'ampFilter')),
        );
    }

    /**
     * Returns an AMP path.
     *
     * @param $path Path
     *
     * @return string
     */
    public function ampFilter($path)
    {
        return $this->config['prefix'].$path;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'takeit_amp_extension';
    }
}
