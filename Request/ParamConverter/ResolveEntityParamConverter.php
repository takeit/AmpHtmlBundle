<?php

/*
 * This file is part of the takeit/AmpHtmlBundle package.
 *
 * (c) Rafał Muszyński <rmuszynski1@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Takeit\Bundle\AmpHtmlBundle\Request\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\DoctrineParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ManagerRegistry;
use Takeit\Bundle\AmpHtmlBundle\Model\AmpInterface;

/**
 * ResolveEntityParamConverter converts AmpInterface instances to a target entity.
 *
 * @author Rafał Muszyński <rmuszynski1@gmail.com>
 */
class ResolveEntityParamConverter extends DoctrineParamConverter
{
    /**
     * @var ManagerRegistry
     */
    protected $registry;

    /**
     * @var array
     */
    protected $mapping;

    /**
     * @param array                $mapping  Interface to entity mapping
     * @param ManagerRegistry|null $registry Registry manager
     */
    public function __construct(array $mapping, ManagerRegistry $registry = null)
    {
        $this->mapping = $mapping;
        $this->registry = $registry;

        parent::__construct($registry);
    }

    /**
     * {@inheritdoc}
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        return parent::apply($request, $this->resolveTargetEntity($configuration));
    }

    /**
     * {@inheritdoc}
     */
    public function supports(ParamConverter $configuration)
    {
        if (AmpInterface::class !== $configuration->getClass()) {
            return false;
        }

        return parent::supports($this->resolveTargetEntity($configuration));
    }

    /**
     * Resolves the target entity.
     *
     * @param ParamConverter $configuration Contains the name, class and options of the object
     *
     * @return ParamConverter
     */
    protected function resolveTargetEntity(ParamConverter $configuration)
    {
        $class = $configuration->getClass();
        if (isset($this->mapping[$class])) {
            if ($this->mapping[$class] !== $class) {
                $configuration->setClass($this->mapping[$class]);
            }
        }

        return $configuration;
    }
}
