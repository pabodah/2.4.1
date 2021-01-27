<?php
/**
 * Copyright © Paboda Hettiarachchi. All rights reserved.
 */

namespace Paboda\PriceRule\Controller\Adminhtml\PriceRule;

use Paboda\PriceRule\Controller\Adminhtml\PriceRule;

/**
 * Class Delete
 *
 * @package Paboda\PriceRule\Controller\Adminhtml\PriceRule
 */
class Delete extends PriceRule
{
    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        $id = $this->getRequest()->getParam('price_rule_id');
        if ($id) {
            try {
                $model = $this->_objectManager->create(\Paboda\PriceRule\Model\PriceRule::class);
                $model->load($id);
                $model->delete();

                $this->messageManager->addSuccessMessage(__('You deleted the price rule.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['price_rule_id' => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a price rule to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
