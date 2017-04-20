<?php

declare(strict_types=1);

namespace Ekyna\Bundle\GoogleBundle\Map;

/**
 * Trait MapPoolAwareTrait
 * @package Ekyna\Bundle\GoogleBundle\Map
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
trait MapPoolAwareTrait
{
    protected MapPool $mapPool;


    public function setMapPool(MapPool $mapPool): void
    {
        $this->mapPool = $mapPool;
    }
}
