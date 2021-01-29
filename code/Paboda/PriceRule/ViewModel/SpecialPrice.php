<?php
/**
 * Copyright © Paboda Hettiarachchi. All rights reserved.
 */

namespace Paboda\PriceRule\ViewModel;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Paboda\PriceRule\Model\PriceRuleRepository;
use Paboda\PriceRule\Registry\CurrentProduct;

class SpecialPrice implements ArgumentInterface
{
    /**
     * @var CurrentProduct
     */
    protected $currentProduct;

    /**
     * @var PriceRuleRepository
     */
    protected $priceRuleRepository;

    private $product;
    /**
     * @var PriceCurrencyInterface
     */
    private $priceCurrency;

    /**
     * Discontinued constructor.
     *
     * @param CurrentProduct $currentProduct
     * @param PriceRuleRepository $priceRuleRepository
     * @param PriceCurrencyInterface $priceCurrency
     */
    public function __construct(
        CurrentProduct $currentProduct,
        PriceRuleRepository $priceRuleRepository,
        PriceCurrencyInterface $priceCurrency
    ) {
        $this->currentProduct = $currentProduct;
        $this->priceRuleRepository = $priceRuleRepository;
        $this->priceCurrency = $priceCurrency;
    }

    /**
     * Get price from price rule
     *
     * @param ProductInterface $product
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getPrice(ProductInterface $product)
    {
        $items = $this->priceRuleRepository->getCustomerPriceBySku($product->getSku());

        if ($items != null) {
            foreach ($items as $item) {
                return __("Your Price: %1%2", $this->priceCurrency->getCurrencySymbol(), $item->getPrice());
            }
        }
    }
}
