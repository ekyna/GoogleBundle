<?php

namespace Ekyna\Bundle\GoogleBundle\Twig;

/**
 * Trait MapPoolAwareTrait
 * @package Ekyna\Bundle\GoogleBundle\Twig
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
trait MapPoolAwareTrait
{
    /**
     * @var MapPool
     */
    protected $mapPool;

    /**
     * Sets the mapPool.
     *
     * @param MapPool $mapPool
     */
    public function setMapPool(MapPool $mapPool)
    {
        $this->mapPool = $mapPool;
    }
}
