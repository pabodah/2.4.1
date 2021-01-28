<?php
/**
 * Copyright © Paboda Hettiarachchi. All rights reserved.
 */

namespace Paboda\PriceRule\Observer;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\Event\Observer as Event;
use Magento\Framework\Event\ObserverInterface;
use Paboda\PriceRule\Registry\CurrentProduct;

class RegisterCurrentProductObserver implements ObserverInterface
{
    /**
     * @var CurrentProduct
     */
    private $currentProduct;

    /**
     * RegisterCurrentProductObserver constructor.
     *
     * @param CurrentProduct $currentProduct
     */
    public function __construct(
        CurrentProduct $currentProduct
    ) {
        $this->currentProduct = $currentProduct;
    }

    /**
     * Trigger event
     *
     * @param Event $event
     */
    public function execute(Event $event)
    {
        /** @var ProductInterface $product */
        $product = $event->getData('product');
        $this->currentProduct->set($product);
    }
}
