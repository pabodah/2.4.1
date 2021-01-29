<?php
/**
 * Copyright © Paboda Hettiarachchi. All rights reserved.
 */

namespace Paboda\PriceRule\ViewModel;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Paboda\PriceRule\Registry\CurrentProduct;

class Product implements ArgumentInterface
{
    /**
     * @var CurrentProduct
     */
    private $currentProduct;

    /**
     * @var ProductInterface
     */
    private $product;

    /**
     * Product constructor.
     *
     * @param CurrentProduct $currentProduct
     */
    public function __construct(
        CurrentProduct $currentProduct
    ) {
        $this->currentProduct = $currentProduct;
    }

    /**
     * Get current product
     *
     * @return ProductInterface
     */
    public function getCurrentProduct(): ProductInterface
    {
        if (is_null($this->product)) {
            $this->product = $this->currentProduct->get();
        }
        return $this->product;
    }
}
