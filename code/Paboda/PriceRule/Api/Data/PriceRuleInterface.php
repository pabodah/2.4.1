<?php
/**
 * Copyright © Paboda Hettiarachchi. All rights reserved.
 */
namespace Paboda\PriceRule\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Interface PriceRuleInterface
 *
 */
interface PriceRuleInterface extends ExtensibleDataInterface
{
    const CUSTOMER_ID = 'customer_id';
    const END_DATE = 'end_date';
    const START_DATE = 'start_date';
    const PRICE_RULE_ID = 'price_rule_id';
    const SKU = 'sku';
    const PRICE = 'price';

    /**
     * Get price_rule_id
     *
     * @return string|null
     */
    public function getPriceRuleId();

    /**
     * Set price_rule_id
     *
     * @param string $priceRuleId
     * @return \Paboda\PriceRule\Api\Data\PriceRuleInterface
     */
    public function setPriceRuleId($priceRuleId);

    /**
     * Get SKU
     *
     * @return string|null
     */
    public function getSku();

    /**
     * Set SKU
     *
     * @param string $sku
     * @return \Paboda\PriceRule\Api\Data\PriceRuleInterface
     */
    public function setSku($sku);

    /**
     * Retrieve existing extension attributes object or create a new one
     *
     * @return \Paboda\PriceRule\Api\Data\PriceRuleExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object
     *
     * @param \Paboda\PriceRule\Api\Data\PriceRuleExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Paboda\PriceRule\Api\Data\PriceRuleExtensionInterface $extensionAttributes
    );

    /**
     * Get customer_id
     *
     * @return string|null
     */
    public function getCustomerId();

    /**
     * Set customer_id
     *
     * @param string $customerId
     * @return \Paboda\PriceRule\Api\Data\PriceRuleInterface
     */
    public function setCustomerId($customerId);

    /**
     * Get price
     *
     * @return string|null
     */
    public function getPrice();

    /**
     * Set price
     *
     * @param string $price
     * @return \Paboda\PriceRule\Api\Data\PriceRuleInterface
     */
    public function setPrice($price);

    /**
     * Get start_date
     *
     * @return string|null
     */
    public function getStartDate();

    /**
     * Set start_date
     *
     * @param string $startDate
     * @return \Paboda\PriceRule\Api\Data\PriceRuleInterface
     */
    public function setStartDate($startDate);

    /**
     * Get end_date
     *
     * @return string|null
     */
    public function getEndDate();

    /**
     * Set end_date
     *
     * @param string $endDate
     * @return \Paboda\PriceRule\Api\Data\PriceRuleInterface
     */
    public function setEndDate($endDate);
}
