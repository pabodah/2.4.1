<?php
/**
 * Copyright © Paboda Hettiarachchi. All rights reserved.
 */

namespace Paboda\PriceRule\Controller\Adminhtml\PriceRule;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Paboda\PriceRule\Api\Data\PriceRuleInterface;
use Paboda\PriceRule\Model\PriceRuleFactory;
use Paboda\PriceRule\Model\ResourceModel\PriceRule as PriceRuleResource;

/**
 * Class Save
 *
 * Save record by form
 */
class Save extends Action
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var PriceRuleFactory
     */
    protected $priceRuleResource;

    /**
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param PriceRuleResource $priceRuleResource
     * @param PriceRuleFactory $priceRuleFactory
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        PriceRuleResource $priceRuleResource,
        PriceRuleFactory $priceRuleFactory
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
        $this->priceRuleResource = $priceRuleResource;
        $this->priceRuleFactory = $priceRuleFactory;
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam(PriceRuleInterface::PRICE_RULE_ID);

            $model = $this->priceRuleFactory->create();
            $this->priceRuleResource->load($model, $id);

            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This price rule no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            $model->setData($data);

            try {
                $this->priceRuleResource->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the price rule.'));
                $this->dataPersistor->clear('paboda_pricerule_pricerule');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath(
                        '*/*/edit',
                        [
                            PriceRuleInterface::PRICE_RULE_ID => $model->getId()
                        ]
                    );
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the price rule.'));
            }

            $this->dataPersistor->set('paboda_pricerule_pricerule', $data);
            return $resultRedirect->setPath(
                '*/*/edit',
                [
                    PriceRuleInterface::PRICE_RULE_ID => $this->getRequest()
                        ->getParam(PriceRuleInterface::PRICE_RULE_ID)
                ]
            );
        }
        return $resultRedirect->setPath('*/*/');
    }
}
