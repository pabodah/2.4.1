<?php
/**
 * Copyright © Paboda Hettiarachchi. All rights reserved.
 */

namespace Paboda\PriceRule\Controller\Adminhtml\PriceRule;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class Save
 *
 * @package Paboda\PriceRule\Controller\Adminhtml\PriceRule
 */
class Save extends Action
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
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
            $id = $this->getRequest()->getParam('price_rule_id');

            $model = $this->_objectManager->create(\Paboda\PriceRule\Model\PriceRule::class)->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This price rule no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the price rule.'));
                $this->dataPersistor->clear('paboda_pricerule_pricerule');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['price_rule_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the price rule.'));
            }

            $this->dataPersistor->set('paboda_pricerule_pricerule', $data);
            return $resultRedirect->setPath('*/*/edit', ['price_rule_id' => $this->getRequest()->getParam('price_rule_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
