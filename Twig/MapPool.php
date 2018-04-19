<?php

namespace Ekyna\Bundle\GoogleBundle\Twig;

use Ivory\GoogleMap\Map;

/**
 * Class MapPool
 * @package Ekyna\Bundle\GoogleBundle\Twig
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class MapPool
{
    /**
     * @var Map[]
     */
    private $maps;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->clear();
    }

    /**
     * Adds the map.
     *
     * @param Map $map
     *
     * @return MapPool
     */
    public function add(Map $map)
    {
        if (false === $index = $this->index($map)) {
            $this->maps[] = $map;
        }

        return $this;
    }

    /**
     * Removes the map.
     *
     * @param Map $map
     *
     * @return MapPool
     */
    public function remove(Map $map)
    {
        if (false !== $index = $this->index($map)) {
            unset($this->maps[$index]);
        }

        return $this;
    }

    /**
     * Returns all the maps and clears the pool.
     *
     * @return Map[]
     */
    public function all()
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
    private function index(Map $map)
    {
        return array_search($map, $this->maps, true);
    }

    /**
     * Clears the pool.
     */
    public function clear()
    {
        $this->maps = [];
    }
}
