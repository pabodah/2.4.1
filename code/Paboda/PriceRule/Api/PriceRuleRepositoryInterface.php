<?php
/**
 * Copyright © Paboda Hettiarachchi. All rights reserved.
 */
namespace Paboda\PriceRule\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface PriceRuleRepositoryInterface
 *
 * @package Paboda\PriceRule\Api
 */
interface PriceRuleRepositoryInterface
{
    /**
     * Save PriceRule
     *
     * @param \Paboda\PriceRule\Api\Data\PriceRuleInterface $priceRule
     * @return \Paboda\PriceRule\Api\Data\PriceRuleInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Paboda\PriceRule\Api\Data\PriceRuleInterface $priceRule
    );

    /**
     * Retrieve PriceRule
     *
     * @param string $priceRuleId
     * @return \Paboda\PriceRule\Api\Data\PriceRuleInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($priceRuleId);

    /**
     * Retrieve PriceRule matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Paboda\PriceRule\Api\Data\PriceRuleSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete PriceRule
     *
     * @param \Paboda\PriceRule\Api\Data\PriceRuleInterface $priceRule
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Paboda\PriceRule\Api\Data\PriceRuleInterface $priceRule
    );

    /**
     * Delete PriceRule by ID
     *
     * @param string $priceRuleId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($priceRuleId);
}
