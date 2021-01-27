<?php
/**
 * Copyright © Paboda Hettiarachchi. All rights reserved.
 */

namespace Paboda\PriceRule\Model\Source;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Products
 *
 * @package Paboda\PriceRule\Model\Source
 */
class Products implements OptionSourceInterface
{
    /**
     * @var CustomerRepositoryInterface
     * */
    protected $customerRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * Constructor
     *
     * @param CustomerRepositoryInterface $customerRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        CollectionFactory $collectionFactory
    ) {
        $this->customerRepository = $customerRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Create option array
     *
     * @return array
     */
    public function toOptionArray()
    {
        $collection = $this->collectionFactory->create();
        $collection
            ->addAttributeToSelect('sku')
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('visibility')
            ->addAttributeToFilter('visibility', ['neq' => 1])
            ->setOrder('sku', 'ASC');

        $ret = [];
        foreach ($collection as $product) {
            $ret[] = [
                'value' => $product->getSku(),
                'label' => $product->getSku(),
            ];
        }

        return $ret;
    }
}
