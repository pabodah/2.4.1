<?php
/**
 * Copyright © Paboda Hettiarachchi. All rights reserved.
 */

namespace Paboda\PriceRule\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Paboda\PriceRule\Registry\CurrentProduct;
use Paboda\PriceRule\Model\PriceRuleRepository;

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
     * Discontinued constructor.
     *
     * @param CurrentProduct $currentProduct
     * @param PriceRuleRepository $priceRuleRepository
     */
    public function __construct(
        CurrentProduct $currentProduct,
        PriceRuleRepository $priceRuleRepository,
    ) {
        $this->currentProduct = $currentProduct;
        $this->priceRuleRepository = $priceRuleRepository;
    }

    /**
     * Get price from price rule
     *
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getPrice()
    {
        $this->product = $this->currentProduct->get();
        $items = $this->priceRuleRepository->getCustomerPriceBySku($this->product->getSku());

        if ($items != null) {
            foreach ($items as $item) {
                return __("Your Price: %1", $item->getPrice());
            }
        }
    }
}
