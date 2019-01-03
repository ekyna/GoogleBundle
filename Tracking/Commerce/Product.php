<?php
declare(strict_types=1);

namespace Ekyna\Bundle\GoogleBundle\Tracking\Commerce;

use Ekyna\Bundle\GoogleBundle\Tracking\Item;

/**
 * Class Product
 * @package Ekyna\Bundle\GoogleBundle\Tracking\Commerce
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class Product implements Item
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
    private $brand;

    /**
     * @var string
     */
    private $category;

    /**
     * @var string
     */
    private $variant;

    /**
     * @var string
     */
    private $price;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @var int
     */
    private $listPosition;


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
     * @return Product
     */
    public function setId(string $id): Product
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Sets the name.
     *
     * @param string $name
     *
     * @return Product
     */
    public function setName(string $name): Product
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Sets the brand.
     *
     * @param string $brand
     *
     * @return Product
     */
    public function setBrand(string $brand): Product
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Sets the category.
     *
     * @param string $category
     *
     * @return Product
     */
    public function setCategory(string $category): Product
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Sets the variant.
     *
     * @param string $variant
     *
     * @return Product
     */
    public function setVariant(string $variant): Product
    {
        $this->variant = $variant;

        return $this;
    }

    /**
     * Sets the price.
     *
     * @param string $price
     *
     * @return Product
     */
    public function setPrice(string $price): Product
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Sets the quantity.
     *
     * @param int $quantity
     *
     * @return Product
     */
    public function setQuantity(int $quantity): Product
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Sets the position in the list.
     *
     * @param int $position
     *
     * @return Product
     */
    public function setListPosition(int $position): Product
    {
        $this->listPosition = $position;

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
            'brand'         => $this->brand,
            'category'      => $this->category,
            'variant'       => $this->variant,
            'price'         => $this->price,
            'quantity'      => $this->quantity,
            'list_position' => $this->listPosition,
        ]);
    }
}
