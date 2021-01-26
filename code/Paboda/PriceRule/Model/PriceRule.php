<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Paboda\PriceRule\Model;

use Magento\Framework\Api\DataObjectHelper;
use Paboda\PriceRule\Api\Data\PriceRuleInterface;
use Paboda\PriceRule\Api\Data\PriceRuleInterfaceFactory;

class PriceRule extends \Magento\Framework\Model\AbstractModel
{

    protected $priceruleDataFactory;

    protected $dataObjectHelper;

    protected $_eventPrefix = 'paboda_pricerule_pricerule';

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param PriceRuleInterfaceFactory $priceruleDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \Paboda\PriceRule\Model\ResourceModel\PriceRule $resource
     * @param \Paboda\PriceRule\Model\ResourceModel\PriceRule\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        PriceRuleInterfaceFactory $priceruleDataFactory,
        DataObjectHelper $dataObjectHelper,
        \Paboda\PriceRule\Model\ResourceModel\PriceRule $resource,
        \Paboda\PriceRule\Model\ResourceModel\PriceRule\Collection $resourceCollection,
        array $data = []
    ) {
        $this->priceruleDataFactory = $priceruleDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve pricerule model with pricerule data
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

