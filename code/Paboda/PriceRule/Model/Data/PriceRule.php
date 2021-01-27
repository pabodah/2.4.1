<?php
/**
 * Copyright © Paboda Hettiarachchi. All rights reserved.
 */

namespace Paboda\PriceRule\Model\Data;

use Magento\Framework\Api\AbstractExtensibleObject;
use Paboda\PriceRule\Api\Data\PriceRuleInterface;

class PriceRule extends AbstractExtensibleObject implements PriceRuleInterface
{
    /**
     * Get price_rule_id
     *
     * @return string|null
     */
    public function getPriceRuleId()
    {
        return $this->_get(self::PRICE_RULE_ID);
    }

    /**
     * Set price_rule_id
     *
     * @param string $priceRuleId
     * @return \Paboda\PriceRule\Api\Data\PriceRuleInterface
     */
    public function setPriceRuleId($priceRuleId)
    {
        return $this->setData(self::PRICE_RULE_ID, $priceRuleId);
    }

    /**
     * Get SKU
     *
     * @return string|null
     */
    public function getSku()
    {
        return $this->_get(self::SKU);
    }

    /**
     * Set SKU
     *
     * @param string $sku
     * @return \Paboda\PriceRule\Api\Data\PriceRuleInterface
     */
    public function setSku($sku)
    {
        return $this->setData(self::SKU, $sku);
    }

    /**
     * Retrieve existing extension attributes object or create a new one
     *
     * @return \Paboda\PriceRule\Api\Data\PriceRuleExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     *
     * @param \Paboda\PriceRule\Api\Data\PriceRuleExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Paboda\PriceRule\Api\Data\PriceRuleExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Get customer_id
     *
     * @return string|null
     */
    public function getCustomerId()
    {
        return $this->_get(self::CUSTOMER_ID);
    }

    /**
     * Set customer_id
     *
     * @param string $customerId
     * @return \Paboda\PriceRule\Api\Data\PriceRuleInterface
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     * Get price
     *
     * @return string|null
     */
    public function getPrice()
    {
        return $this->_get(self::PRICE);
    }

    /**
     * Set price
     *
     * @param string $price
     * @return \Paboda\PriceRule\Api\Data\PriceRuleInterface
     */
    public function setPrice($price)
    {
        return $this->setData(self::PRICE, $price);
    }

    /**
     * Get start_date
     *
     * @return string|null
     */
    public function getStartDate()
    {
        return $this->_get(self::START_DATE);
    }

    /**
     * Set start_date
     *
     * @param string $startDate
     * @return \Paboda\PriceRule\Api\Data\PriceRuleInterface
     */
    public function setStartDate($startDate)
    {
        return $this->setData(self::START_DATE, $startDate);
    }

    /**
     * Get end_date
     *
     * @return string|null
     */
    public function getEndDate()
    {
        return $this->_get(self::END_DATE);
    }

    /**
     * Set end_date
     *
     * @param string $endDate
     * @return \Paboda\PriceRule\Api\Data\PriceRuleInterface
     */
    public function setEndDate($endDate)
    {
        return $this->setData(self::END_DATE, $endDate);
    }
}
