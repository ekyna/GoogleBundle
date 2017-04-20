<?php

declare(strict_types=1);

namespace Ekyna\Bundle\GoogleBundle\Tracking\Commerce;

use Ekyna\Bundle\GoogleBundle\Tracking\Item;

/**
 * Class Impression
 * @package Ekyna\Bundle\GoogleBundle\Tracking\Commerce
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class Impression implements Item
{
    private string  $id;
    private string  $name;
    private ?string $listName     = null;
    private ?string $brand        = null;
    private ?string $category     = null;
    private ?string $variant      = null;
    private ?int    $listPosition = null;
    private ?string $price        = null;


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
     * @return Impression
     */
    public function setId(string $id): Impression
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Sets the name.
     *
     * @param string $name
     *
     * @return Impression
     */
    public function setName(string $name): Impression
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Sets the list name.
     *
     * @param string $listName
     *
     * @return Impression
     */
    public function setListName(string $listName): Impression
    {
        $this->listName = $listName;

        return $this;
    }

    /**
     * Sets the brand.
     *
     * @param string $brand
     *
     * @return Impression
     */
    public function setBrand(string $brand): Impression
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Sets the category.
     *
     * @param string $category
     *
     * @return Impression
     */
    public function setCategory(string $category): Impression
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Sets the variant.
     *
     * @param string $variant
     *
     * @return Impression
     */
    public function setVariant(string $variant): Impression
    {
        $this->variant = $variant;

        return $this;
    }

    /**
     * Sets the position in the list.
     *
     * @param int $position
     *
     * @return Impression
     */
    public function setListPosition(int $position): Impression
    {
        $this->listPosition = $position;

        return $this;
    }

    /**
     * Sets the price.
     *
     * @param string $price
     *
     * @return Impression
     */
    public function setPrice(string $price): Impression
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getData(): array
    {
        return array_filter([
            'id'            => $this->id,
            'name'          => $this->name,
            'list_name'     => $this->listName,
            'brand'         => $this->brand,
            'category'      => $this->category,
            'variant'       => $this->variant,
            'list_position' => $this->listPosition,
            'price'         => $this->price,
        ]);
    }
}
