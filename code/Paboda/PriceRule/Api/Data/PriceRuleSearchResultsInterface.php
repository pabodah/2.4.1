<?php
/**
 * Copyright © Paboda Hettiarachchi. All rights reserved.
 */
namespace Paboda\PriceRule\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface PriceRuleSearchResultsInterface
 *
 */
interface PriceRuleSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get items
     *
     * @return \Magento\Framework\Api\ExtensibleDataInterface[]
     */
    public function getItems();

    /**
     * Set items
     *
     * @param array $items
     * @return PriceRuleSearchResultsInterface
     */
    public function setItems(array $items);
}
