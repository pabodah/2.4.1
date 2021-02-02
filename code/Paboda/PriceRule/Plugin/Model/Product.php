<?php
/**
 * Copyright © Paboda Hettiarachchi. All rights reserved.
 */

namespace Paboda\PriceRule\Plugin\Model;

use Paboda\PriceRule\Model\PriceRuleRepository;
use Paboda\PriceRule\Registry\CurrentProduct;

/**
 * Class Product
 *
 * Get product price
 */
class Product
{
    /**
     * @var CurrentProduct
     */
    protected $currentProduct;

    /**
     * @var PriceRuleRepository
     */
    protected $priceRuleRepository;

    /**
     * Product constructor.
     *
     * @param CurrentProduct $currentProduct
     * @param PriceRuleRepository $priceRuleRepository
     */
    public function __construct(
        CurrentProduct $currentProduct,
        PriceRuleRepository $priceRuleRepository
    ) {
        $this->currentProduct = $currentProduct;
        $this->priceRuleRepository = $priceRuleRepository;
    }

    /**
     * Get Price
     *
     * @param \Magento\Catalog\Model\Product $subject
     * @param $result
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function afterGetPrice(\Magento\Catalog\Model\Product $subject, $result)
    {
        $sku = $this->currentProduct->get()->getSku();
        $items = $this->priceRuleRepository->getCustomerPriceBySku($sku);

        if ($items != null) {
            foreach ($items as $item) {
                return $item->getPrice();
            }
        }
        return $result;
    }
}
