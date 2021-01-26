<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

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
use Paboda\PriceRule\Api\Data\PriceRuleInterfaceFactory;
use Paboda\PriceRule\Api\Data\PriceRuleSearchResultsInterfaceFactory;
use Paboda\PriceRule\Api\PriceRuleRepositoryInterface;
use Paboda\PriceRule\Model\ResourceModel\PriceRule as ResourcePriceRule;
use Paboda\PriceRule\Model\ResourceModel\PriceRule\CollectionFactory as PriceRuleCollectionFactory;

class PriceRuleRepository implements PriceRuleRepositoryInterface
{

    private $storeManager;

    protected $priceRuleFactory;

    protected $dataObjectProcessor;

    private $collectionProcessor;

    protected $extensibleDataObjectConverter;
    protected $priceRuleCollectionFactory;

    protected $searchResultsFactory;

    protected $dataPriceRuleFactory;

    protected $extensionAttributesJoinProcessor;

    protected $resource;

    protected $dataObjectHelper;


    /**
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
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
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
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \Paboda\PriceRule\Api\Data\PriceRuleInterface $priceRule
    ) {
        /* if (empty($priceRule->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $priceRule->setStoreId($storeId);
        } */
        
        $priceRuleData = $this->extensibleDataObjectConverter->toNestedArray(
            $priceRule,
            [],
            \Paboda\PriceRule\Api\Data\PriceRuleInterface::class
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
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->priceRuleCollectionFactory->create();
        
        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Paboda\PriceRule\Api\Data\PriceRuleInterface::class
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
     * {@inheritdoc}
     */
    public function delete(
        \Paboda\PriceRule\Api\Data\PriceRuleInterface $priceRule
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
     * {@inheritdoc}
     */
    public function deleteById($priceRuleId)
    {
        return $this->delete($this->get($priceRuleId));
    }
}

