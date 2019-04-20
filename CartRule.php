<?php
/**
 * Class CartRuleCore
 */
class CartRuleCore extends ObjectModel
{
    /* Filters used when retrieving the cart rules applied to a cart of when calculating the value of a reduction */

	const CICCIO = 1;
    const FILTER_ACTION_ALL = 1;
    const FILTER_ACTION_SHIPPING = 2;
    const FILTER_ACTION_REDUCTION = 3;
    const FILTER_ACTION_GIFT = 4;
    const FILTER_ACTION_ALL_NOCAP = 5;
    const BO_ORDER_CODE_PREFIX = 'BO_ORDER_';

    /**
     * This variable controls that a free gift is offered only once, even when multi-shippping is activated
     * and the same product is delivered in both addresses
     *
     * @var array
     */
    protected static $only_one_gift = array();

    public $id;
    public $name;
    public $id_customer;
    public $date_from;
    public $date_to;
    public $description;
    public $quantity = 1;
    public $quantity_per_user = 1;
    public $priority = 1;
    public $partial_use = 1;
    public $code;
    public $minimum_amount;
    public $minimum_amount_tax;
    public $minimum_amount_currency;
    public $minimum_amount_shipping;
    public $country_restriction;
    public $carrier_restriction;
    public $group_restriction;
    public $cart_rule_restriction;
    public $product_restriction;
    public $shop_restriction;
    public $free_shipping;
    public $reduction_percent;
    public $reduction_amount;
    public $reduction_tax;
    public $reduction_currency;
    public $reduction_product;
    public $reduction_exclude_special;
    public $gift_product;
    public $gift_product_attribute;
    public $highlight;
    public $active = 1;
    public $date_add;
    public $date_upd;

    protected static $cartAmountCache = array();

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'cart_rule',
        'primary' => 'id_cart_rule',
        'multilang' => true,
        'fields' => array(
            'id_customer' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'date_from' => array('type' => self::TYPE_DATE, 'validate' => 'isDate', 'required' => true),
            'date_to' => array('type' => self::TYPE_DATE, 'validate' => 'isDate', 'required' => true),
            'description' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 65534),
            'quantity' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'quantity_per_user' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'priority' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'partial_use' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'code' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 254),
            'minimum_amount' => array('type' => self::TYPE_FLOAT, 'validate' => 'isFloat'),
            'minimum_amount_tax' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'minimum_amount_currency' => array('type' => self::TYPE_INT, 'validate' => 'isInt'),
            'minimum_amount_shipping' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'country_restriction' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'carrier_restriction' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'group_restriction' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'cart_rule_restriction' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'product_restriction' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'shop_restriction' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'free_shipping' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'reduction_percent' => array('type' => self::TYPE_FLOAT, 'validate' => 'isPercentage'),
            'reduction_amount' => array('type' => self::TYPE_FLOAT, 'validate' => 'isFloat'),
            'reduction_tax' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'reduction_currency' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'reduction_product' => array('type' => self::TYPE_INT, 'validate' => 'isInt'),
            'reduction_exclude_special' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'gift_product' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'gift_product_attribute' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'highlight' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'active' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'date_add' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'date_upd' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            /* Lang fields */
            'name' => array(
                'type' => self::TYPE_STRING,
                'lang' => true,
                'validate' => 'isCleanHtml',
                'required' => true, 'size' => 254
            ),
        ),
    );
