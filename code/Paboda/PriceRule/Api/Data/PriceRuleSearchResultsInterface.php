<?php

declare(strict_types=1);

namespace Paboda\PriceRule\Api\Data;

interface PriceRuleSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get PriceRule list.
     * @return \Paboda\PriceRule\Api\Data\PriceRuleInterface[]
     */
    public function getItems();

    /**
     * Set sku list.
     * @param \Paboda\PriceRule\Api\Data\PriceRuleInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

