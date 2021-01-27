<?php
/**
 * Copyright © Paboda Hettiarachchi. All rights reserved.
 */

namespace Paboda\PriceRule\Controller\Adminhtml\PriceRule;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Paboda\PriceRule\Model\PriceRule;
use Paboda\PriceRule\Model\PriceRuleFactory;
use Paboda\PriceRule\Model\ResourceModel\PriceRule as PriceRuleResource;

class InlineEdit extends Action
{
    /**
     * @var JsonFactory
     */
    protected $jsonFactory;

    /**
     * @var PriceRuleFactory
     */
    protected $priceRuleFactory;

    /**
     * @var PriceRuleResource
     */
    protected $priceRuleResource;

    /**
     * Constructor
     *
     * @param Context $context
     * @param JsonFactory $jsonFactory
     * @param PriceRuleFactory $priceRuleFactory
     * @param PriceRuleResource $priceRuleResource
     */
    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        PriceRuleFactory $priceRuleFactory,
        PriceRuleResource $priceRuleResource
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->priceRuleFactory = $priceRuleFactory;
        $this->priceRuleResource = $priceRuleResource;
    }

    /**
     * Inline edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $modelid) {
                    /** @var PriceRule $model */
                    $model = $this->priceRuleFactory->create();
                    $this->priceRuleResource->load($model, $modelid);

                    try {
                        $model->setData(array_merge($model->getData(), $postItems[$modelid]));
                        $this->priceRuleResource->save($model);
                    } catch (\Exception $e) {
                        $messages[] = "[Pricerule ID: {$modelid}]  {$e->getMessage()}";
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}
