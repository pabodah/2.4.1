<?php

namespace Paboda\PriceRule\Model\Source;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Data\OptionSourceInterface;

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
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param CustomerRepositoryInterface $customerRepository
     * @param SearchCriteriaBuilder       $searchCriteriaBuilder
     * */
    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory

    ) {
        $this->customerRepository    = $customerRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $collection = $this->collectionFactory->create();
        $collection
            ->addAttributeToSelect('sku')
            ->addAttributeToSelect('name')
            ->setOrder('sku', 'ASC');

        $ret        = [];
        foreach ($collection as $product) {
            $ret[] = [
                'value' => $product->getSku(),
                'label' => $product->getSku(),
            ];
        }

        return $ret;
    }
}
