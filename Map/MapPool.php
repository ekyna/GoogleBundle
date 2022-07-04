<?php

declare(strict_types=1);

namespace Ekyna\Bundle\GoogleBundle\Map;

use Ivory\GoogleMap\Map;

/**
 * Class MapPool
 * @package Ekyna\Bundle\GoogleBundle\Twig
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class MapPool
{
    /** @var Map[] */
    private array $maps;


    public function __construct()
    {
        $this->clear();
    }

    public function add(Map $map): MapPool
    {
        if (false === $this->index($map)) {
            $this->maps[] = $map;
        }

        return $this;
    }

    public function remove(Map $map): MapPool
    {
        if (false !== $index = $this->index($map)) {
            unset($this->maps[$index]);
        }

        return $this;
    }

    /**
     * @return Map[]
     */
    public function all(): array
    {
        $maps = $this->maps;

        $this->clear();

        return $maps;
    }

    /**
     * Returns the map index.
     *
     * @param Map $map
     *
     * @return false|int
     */
    private function index(Map $map): bool|int
    {
        return array_search($map, $this->maps, true);
    }

    /**
     * Clears the pool.
     */
    public function clear(): void
    {
        $this->maps = [];
    }
}
