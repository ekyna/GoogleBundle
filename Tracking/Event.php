<?php
declare(strict_types=1);

namespace Ekyna\Bundle\GoogleBundle\Tracking;

use Ekyna\Bundle\GoogleBundle\Tracking\Commerce;

/**
 * Class Action
 * @package Ekyna\Bundle\GoogleBundle\Tracking
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class Event
{
    const ADD_PAYMENT_INFO    = 'add_payment_info';
    const ADD_TO_CART         = 'add_to_cart';
    const ADD_TO_WISHLIST     = 'add_to_wishlist';
    const BEGIN_CHECKOUT      = 'begin_checkout';
    const CHECKOUT_PROGRESS   = 'checkout_progress';
    const GENERATE_LEAD       = 'generate_lead';
    const LOGIN               = 'login';
    const PAGE_VIEW           = 'page_view';
    const PURCHASE            = 'purchase';
    const CONVERSION          = 'conversion';
    const REFUND              = 'refund';
    const REMOVE_FROM_CART    = 'remove_from_cart';
    const SCREEN_VIEW         = 'screen_view';
    const SEARCH              = 'search';
    const SELECT_CONTENT      = 'select_content';
    const SET_CHECKOUT_OPTION = 'set_checkout_option';
    const SHARE               = 'share';
    const SIGN_UP             = 'sign_up';
    const VIEW_ITEM           = 'view_item';
    const VIEW_ITEM_LIST      = 'view_item_list';
    const VIEW_PROMOTION      = 'view_promotion';
    const VIEW_SEARCH_RESULTS = 'view_search_results';

    const CONTENT_PRODUCT     = 'product';
    const CONTENT_PROMOTION   = 'promotion';


    /**
     * Returns the event types.
     *
     * @return array
     */
    static public function getEventTypes(): array
    {
        return [
            self::ADD_PAYMENT_INFO,
            self::ADD_TO_CART,
            self::ADD_TO_WISHLIST,
            self::BEGIN_CHECKOUT,
            self::CHECKOUT_PROGRESS,
            self::GENERATE_LEAD,
            self::LOGIN,
            self::PAGE_VIEW,
            self::PURCHASE,
            self::CONVERSION,
            self::REFUND,
            self::REMOVE_FROM_CART,
            self::SCREEN_VIEW,
            self::SEARCH,
            self::SELECT_CONTENT,
            self::SET_CHECKOUT_OPTION,
            self::SHARE,
            self::SIGN_UP,
            self::VIEW_ITEM,
            self::VIEW_ITEM_LIST,
            self::VIEW_PROMOTION,
            self::VIEW_SEARCH_RESULTS,
        ];
    }

    /**
     * Validates the event type.
     *
     * @param string $type
     */
    static public function validateEventType(string $type)
    {
        if (!in_array($type, self::getEventTypes(), true)) {
            throw new \UnexpectedValueException("Event type '$type' is not valid.");
        }
    }

    /**
     * Returns the content types.
     *
     * @return array
     */
    static public function getContentTypes(): array
    {
        return [
            self::CONTENT_PRODUCT,
            self::CONTENT_PROMOTION,
        ];
    }

    /**
     * Validates the content type.
     *
     * @param string $type
     */
    static public function validateContentType(string $type)
    {
        if (!in_array($type, self::getContentTypes(), true)) {
            throw new \UnexpectedValueException("Content type '$type' is not valid.");
        }
    }


    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $transactionId;

    /**
     * @var string
     */
    private $affiliation;

    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $tax;

    /**
     * @var string
     */
    private $shipping;

    /**
     * @var int
     */
    private $checkoutStep;

    /**
     * @var string
     */
    private $checkoutOption;

    /**
     * @var Item[]
     */
    private $items = [];

    /**
     * @var string
     */
    private $contentType;

    /**
     * @var string
     */
    private $coupon;

    /**
     * @var array
     */
    private $extra = [];


    /**
     * Constructor.
     *
     * @param string $type
     */
    public function __construct(string $type)
    {
        $this->setType($type);
    }

    /**
     * Sets the type.
     *
     * @param string $type
     *
     * @return Event
     */
    public function setType(string $type): Event
    {
        self::validateEventType($type);

        $this->type = $type;

        return $this;
    }

    /**
     * Returns the type.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Sets the transaction id.
     *
     * @param string $id
     *
     * @return Event
     */
    public function setTransactionId(string $id): Event
    {
        $this->transactionId = $id;

        return $this;
    }

    /**
     * Sets the affiliation.
     *
     * @param string $affiliation
     *
     * @return Event
     */
    public function setAffiliation(string $affiliation): Event
    {
        $this->affiliation = $affiliation;

        return $this;
    }

    /**
     * Sets the value.
     *
     * @param string $value
     *
     * @return Event
     */
    public function setValue(string $value): Event
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Sets the tax.
     *
     * @param string $tax
     *
     * @return Event
     */
    public function setTax(string $tax): Event
    {
        $this->tax = $tax;

        return $this;
    }

    /**
     * Sets the shipping.
     *
     * @param string $shipping
     *
     * @return Event
     */
    public function setShipping(string $shipping): Event
    {
        $this->shipping = $shipping;

        return $this;
    }

    /**
     * Sets the checkout step.
     *
     * @param int $step
     *
     * @return Event
     */
    public function setCheckoutStep(int $step): Event
    {
        $this->checkoutStep = $step;

        return $this;
    }

    /**
     * Sets the checkout option.
     *
     * @param string $option
     *
     * @return Event
     */
    public function setCheckoutOption(string $option): Event
    {
        $this->checkoutOption = $option;

        return $this;
    }

    /**
     * Adds the item.
     *
     * @param Item $item
     *
     * @return Event
     */
    public function addItem(Item $item): Event
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * Sets the content type.
     *
     * @param string $type
     *
     * @return Event
     */
    public function setContentType(string $type): Event
    {
        self::validateContentType($type);

        $this->contentType = $type;

        return $this;
    }

    /**
     * Sets the coupon.
     *
     * @param string $coupon
     *
     * @return Event
     */
    public function setCoupon(string $coupon): Event
    {
        $this->coupon = $coupon;

        return $this;
    }

    /**
     * Sets the extra.
     *
     * @param array $extra
     *
     * @return Event
     */
    public function setExtra(array $extra): Event
    {
        $this->extra = $extra;

        return $this;
    }

    /**
     * Returns the event data.
     *
     * @return array
     */
    public function getData()
    {
        // TODO Validation regarding to type

        $data = array_filter(array_replace([
            'transaction_id'  => $this->transactionId,
            'affiliation'     => $this->affiliation,
            'value'           => $this->value,
            'tax'             => $this->tax,
            'shipping'        => $this->shipping,
            'checkout_step'   => $this->checkoutStep,
            'checkout_option' => $this->checkoutOption,
        ], $this->extra));

        if (!empty($this->items)) {
            $key = $this->getItemsKey();

            $data[$key] = [];

            foreach ($this->items as $item) {
                $data[$key][] = $item->getData();
            }
        }

        return $data;
    }

    /**
     * Returns the key for the items data.
     *
     * @return string
     */
    private function getItemsKey()
    {
        if ($this->type === self::VIEW_PROMOTION) {
            return 'promotions';
        }

        if (($this->type === self::SELECT_CONTENT) && ($this->contentType === self::CONTENT_PROMOTION)) {
            return 'promotions';
        }

        return 'items';
    }

    /**
     * Validates the event data.
     *
     * @see https://developers.google.com/gtagjs/reference/event
     */
    public function validate()
    {
        // TODO

        switch($this->type) {
            case self::VIEW_ITEM:
            case self::VIEW_ITEM_LIST:
            case self::ADD_PAYMENT_INFO:
            case self::ADD_TO_CART:
            case self::ADD_TO_WISHLIST:
            case self::REMOVE_FROM_CART:
                $this->assertDefined(['items']);
                $this->assertItemsClass(Commerce\Product::class);
                break;

            case self::VIEW_PROMOTION:
                $this->assertDefined(['items']);
                $this->assertItemsClass(Commerce\Promotion::class);
                break;

            case self::SELECT_CONTENT:
                $this->assertDefined(['items']);

                $class = $this->contentType === self::CONTENT_PROMOTION
                    ? Commerce\Promotion::class : Commerce\Product::class;

                $this->assertItemsClass($class);
                break;

            case self::BEGIN_CHECKOUT:
            case self::CHECKOUT_PROGRESS:
            case self::GENERATE_LEAD:
            case self::LOGIN:
            case self::PAGE_VIEW:
            case self::PURCHASE:
            case self::REFUND:
            case self::SCREEN_VIEW:
            case self::SEARCH:
            case self::SET_CHECKOUT_OPTION:
            case self::SHARE:
            case self::SIGN_UP:
            case self::VIEW_SEARCH_RESULTS:
        }
    }

    /**
     * Throws an exception if one of the given properties is not defined.
     *
     * @param array $properties
     */
    private function assertDefined(array $properties)
    {
        foreach ($properties as $property) {
            if (empty($this->{$property})) {
                throw new \InvalidArgumentException("{$this->type}.$property must be set.");
            }
        }
    }

    private function assertItemsClass(string $class)
    {
        foreach ($this->items as $item) {
            if (!$item instanceof $class) {
                throw new \InvalidArgumentException("Expected {$this->type}.items as instances of $class.");
            }
        }
    }
}
