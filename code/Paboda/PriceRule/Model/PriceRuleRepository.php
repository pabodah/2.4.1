<?php
/**
 * Copyright © Paboda Hettiarachchi. All rights reserved.
 */

namespace Paboda\PriceRule\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;
use Paboda\PriceRule\Api\Data\PriceRuleInterface;
use Paboda\PriceRule\Api\Data\PriceRuleInterfaceFactory;
use Paboda\PriceRule\Api\Data\PriceRuleSearchResultsInterfaceFactory;
use Paboda\PriceRule\Api\PriceRuleRepositoryInterface;
use Paboda\PriceRule\Model\ResourceModel\PriceRule as ResourcePriceRule;
use Paboda\PriceRule\Model\ResourceModel\PriceRule\CollectionFactory as PriceRuleCollectionFactory;
use Magento\Customer\Model\SessionFactory;

/**
 * Class PriceRuleRepository
 *
 * Define repository
 */
class PriceRuleRepository implements PriceRuleRepositoryInterface
{
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var PriceRuleFactory
     */
    protected $priceRuleFactory;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var ExtensibleDataObjectConverter
     */
    protected $extensibleDataObjectConverter;

    /**
     * @var PriceRuleCollectionFactory
     */
    protected $priceRuleCollectionFactory;

    /**
     * @var PriceRuleSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var PriceRuleInterfaceFactory
     */
    protected $dataPriceRuleFactory;

    /**
     * @var JoinProcessorInterface
     */
    protected $extensionAttributesJoinProcessor;

    /**
     * @var ResourcePriceRule
     */
    protected $resource;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var SessionFactory
     */
    protected $customerSession;

    /**
     * PriceRuleRepository constructor.
     *
     * @param ResourcePriceRule $resource
     * @param PriceRuleFactory $priceRuleFactory
     * @param PriceRuleInterfaceFactory $dataPriceRuleFactory
     * @param PriceRuleCollectionFactory $priceRuleCollectionFactory
     * @param PriceRuleSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     * @param SessionFactory $customerSession
     */
    public function __construct(
        ResourcePriceRule $resource,
        PriceRuleFactory $priceRuleFactory,
        PriceRuleInterfaceFactory $dataPriceRuleFactory,
        PriceRuleCollectionFactory $priceRuleCollectionFactory,
        PriceRuleSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter,
        SessionFactory $customerSession
    ) {
        $this->resource = $resource;
        $this->priceRuleFactory = $priceRuleFactory;
        $this->priceRuleCollectionFactory = $priceRuleCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataPriceRuleFactory = $dataPriceRuleFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
        $this->customerSession = $customerSession;
    }

    /**
     * Save
     *
     * @param PriceRuleInterface $priceRule
     * @return PriceRuleInterface
     * @throws CouldNotSaveException
     */
    public function save(
        PriceRuleInterface $priceRule
    ) {
        $priceRuleData = $this->extensibleDataObjectConverter->toNestedArray(
            $priceRule,
            [],
            PriceRuleInterface::class
        );

        $priceRuleModel = $this->priceRuleFactory->create()->setData($priceRuleData);

        try {
            $this->resource->save($priceRuleModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the priceRule: %1',
                $exception->getMessage()
            ));
        }
        return $priceRuleModel->getDataModel();
    }

    /**
     * Load data by given id
     *
     * @param string $priceRuleId
     * @return PriceRuleInterface
     * @throws NoSuchEntityException
     */
    public function get($priceRuleId)
    {
        $priceRule = $this->priceRuleFactory->create();
        $this->resource->load($priceRule, $priceRuleId);
        if (!$priceRule->getId()) {
            throw new NoSuchEntityException(__('Price rule with id "%1" does not exist.', $priceRuleId));
        }
        return $priceRule->getDataModel();
    }

    /**
     * Load data collection by given search criteria
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \Paboda\PriceRule\Api\Data\PriceRuleSearchResultsInterface
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->priceRuleCollectionFactory->create();

        $this->extensionAttributesJoinProcessor->process(
            $collection,
            PriceRuleInterface::class
        );

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * Delete
     *
     * @param PriceRuleInterface $priceRule
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(
        PriceRuleInterface $priceRule
    ) {
        try {
            $priceRuleModel = $this->priceRuleFactory->create();
            $this->resource->load($priceRuleModel, $priceRule->getPriceRuleId());
            $this->resource->delete($priceRuleModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the PriceRule: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * Delete by a given id
     *
     * @param string $priceRuleId
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($priceRuleId)
    {
        return $this->delete($this->get($priceRuleId));
    }

    /**
     * Get price by SKU
     *
     * @param $sku
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getCustomerPriceBySku($sku)
    {
        $customer = $this->customerSession->create();
        if ($customer->isLoggedIn()) {
            $collection = $this->priceRuleCollectionFactory->create();
            $collection->addFieldToFilter('customer_id', $customer->getId());
            $collection->addFieldToFilter('sku', $sku);
            return $collection;
        }
        return null;
    }
}
