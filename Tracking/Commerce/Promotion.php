<?php
declare(strict_types=1);

namespace Ekyna\Bundle\GoogleBundle\Tracking\Commerce;

use Ekyna\Bundle\GoogleBundle\Tracking\Item;

/**
 * Class Promotion
 * @package Ekyna\Bundle\GoogleBundle\Tracking\Commerce
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class Promotion implements Item
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $creativeName;

    /**
     * @var string
     */
    private $creativeSlot;


    /**
     * Constructor.
     *
     * @param string $id
     * @param string $name
     */
    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * Sets the id.
     *
     * @param string $id
     *
     * @return Promotion
     */
    public function setId(string $id): Promotion
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Sets the name.
     *
     * @param string $name
     *
     * @return Promotion
     */
    public function setName(string $name): Promotion
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Sets the creative name.
     *
     * @param string $name
     *
     * @return Promotion
     */
    public function setCreativeName(string $name): Promotion
    {
        $this->creativeName = $name;

        return $this;
    }

    /**
     * Sets the creative slot.
     *
     * @param string $slot
     *
     * @return Promotion
     */
    public function setCreativeSlot(string $slot): Promotion
    {
        $this->creativeSlot = $slot;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        return array_filter([
            'id'            => $this->id,
            'name'          => $this->name,
            'creative_name' => $this->creativeName,
            'creative_slot' => $this->creativeSlot,
        ]);
    }
}
