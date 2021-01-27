<?php
/**
 * Copyright © Paboda Hettiarachchi. All rights reserved.
 */

namespace Paboda\PriceRule\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Paboda\PriceRule\Api\Data\PriceRuleInterface;
use Paboda\PriceRule\Api\Data\PriceRuleInterfaceFactory;
use Paboda\PriceRule\Model\ResourceModel\PriceRule\Collection;

/**
 * Class PriceRule
 *
 * @package Paboda\PriceRule\Model
 */
class PriceRule extends AbstractModel
{
    /**
     * @var PriceRuleInterfaceFactory
     */
    protected $priceruleDataFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var string
     */
    protected $_eventPrefix = 'paboda_pricerule_pricerule';

    /**
     * Constructor
     *
     * @param Context $context
     * @param Registry $registry
     * @param PriceRuleInterfaceFactory $priceruleDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param ResourceModel\PriceRule $resource
     * @param Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        PriceRuleInterfaceFactory $priceruleDataFactory,
        DataObjectHelper $dataObjectHelper,
        ResourceModel\PriceRule $resource,
        Collection $resourceCollection,
        array $data = []
    ) {
        $this->priceruleDataFactory = $priceruleDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve price rule model with price rule data
     *
     * @return PriceRuleInterface
     */
    public function getDataModel()
    {
        $priceruleData = $this->getData();

        $priceruleDataObject = $this->priceruleDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $priceruleDataObject,
            $priceruleData,
            PriceRuleInterface::class
        );

        return $priceruleDataObject;
    }
}
