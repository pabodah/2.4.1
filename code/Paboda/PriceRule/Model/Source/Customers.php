<?php

namespace Paboda\PriceRule\Model\Source;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Data\OptionSourceInterface;

class Customers implements OptionSourceInterface
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
     * @param CustomerRepositoryInterface $customerRepository
     * @param SearchCriteriaBuilder       $searchCriteriaBuilder
     * */
    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->customerRepository    = $customerRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $arr = $this->toArray();
        $ret = [];

        foreach ($arr as $key => $value) {
            $ret[] = [
                'value' => $key,
                'label' => $value
            ];
        }

        return $ret;
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function toArray()
    {
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $customers      = $this->customerRepository->getList($searchCriteria)->getItems();

        $customersList = [];
        foreach ($customers as $customer) {
            $customersList[$customer->getId()] = __($customer->getFirstname() . ' ' . $customer->getLastname());
        }

        return $customersList;
    }
}
