<?php
/**
 * Copyright © Paboda Hettiarachchi. All rights reserved.
 */

namespace Paboda\PriceRule\Pricing\Render;

use Magento\Catalog\Model\Product\Pricing\Renderer\SalableResolverInterface;
use Magento\Catalog\Pricing\Price\MinimalPriceCalculatorInterface;
use Magento\Framework\Pricing\Price\PriceInterface;
use Magento\Framework\Pricing\Render\RendererPool;
use Magento\Framework\Pricing\SaleableInterface;
use Magento\Framework\View\Element\Template\Context;
use Paboda\PriceRule\Model\PriceRuleRepository;

/**
 * Class FinalPriceBox
 *
 * Use pricebox
 */
class FinalPriceBox extends \Magento\Catalog\Pricing\Render\FinalPriceBox
{
    protected $priceRuleRepository;

    /**
     * FinalPriceBox constructor.
     *
     * @param Context $context
     * @param SaleableInterface $saleableItem
     * @param PriceInterface $price
     * @param RendererPool $rendererPool
     * @param PriceRuleRepository $priceRuleRepository
     * @param array $data
     * @param SalableResolverInterface|null $salableResolver
     * @param MinimalPriceCalculatorInterface|null $minimalPriceCalculator
     */
    public function __construct(
        Context $context,
        SaleableInterface $saleableItem,
        PriceInterface $price,
        RendererPool $rendererPool,
        PriceRuleRepository $priceRuleRepository,
        array $data = [],
        SalableResolverInterface $salableResolver = null,
        MinimalPriceCalculatorInterface $minimalPriceCalculator = null

    ) {
        parent::__construct(
            $context,
            $saleableItem,
            $price,
            $rendererPool,
            $data,
            $salableResolver,
            $minimalPriceCalculator
        );
        $this->priceRuleRepository = $priceRuleRepository;
    }

    /**
     * Set the price label
     *
     * @param string $html
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function wrapResult($html)
    {
        $priceText = '';
        $sku = $this->getSaleableItem()->getSku();
        $items = $this->priceRuleRepository->getCustomerPriceBySku($sku);

        if ($items != null && $items->getSize() > 0) {
            $priceText = __('Your price');
        }
        return $priceText . '<div class="price-box ' . $this->getData('css_classes') . '" ' .
            'data-role="priceBox" ' .
            'data-product-id="' . $this->getSaleableItem()->getId() . '" ' .
            'data-price-box="product-id-' . $this->getSaleableItem()->getId() . '"' .
            '>' . $html . '</div>';
    }
}
