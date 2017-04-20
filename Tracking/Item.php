<?php

declare(strict_types=1);

namespace Ekyna\Bundle\GoogleBundle\Tracking;

/**
 * Interface Item
 * @package Ekyna\Bundle\GoogleBundle\Tracking
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
interface Item
{
    /**
     * Returns the item data.
     *
     * @return array
     */
    public function getData(): array;
}
