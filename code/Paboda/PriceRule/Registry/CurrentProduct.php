<?php
/**
 * Copyright © Paboda Hettiarachchi. All rights reserved.
 */

namespace Paboda\PriceRule\Registry;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\Data\ProductInterfaceFactory;

class CurrentProduct
{
    /**
     * @var ProductInterface
     */
    private $product;

    /**
     * @var ProductInterfaceFactory
     */
    private $productFactory;

    /**
     * CurrentProduct constructor.
     *
     * @param ProductInterfaceFactory $productFactory
     */
    public function __construct(
        ProductInterfaceFactory $productFactory
    ) {
        $this->productFactory = $productFactory;
    }

    /**
     * Setter
     *
     * @param ProductInterface $product
     */
    public function set(ProductInterface $product): void
    {
        $this->product = $product;
    }

    /**
     * Getter
     *
     * @return ProductInterface
     */
    public function get(): ProductInterface
    {
        return $this->product ?? $this->createProduct();
    }

    /**
     * Product factory
     *
     * @return ProductInterface
     */
    private function createProduct(): ProductInterface
    {
        return $this->productFactory->create();
    }
}
