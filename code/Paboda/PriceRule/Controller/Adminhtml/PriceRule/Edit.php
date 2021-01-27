<?php
/**
 * Copyright © Paboda Hettiarachchi. All rights reserved.
 */

namespace Paboda\PriceRule\Controller\Adminhtml\PriceRule;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Paboda\PriceRule\Controller\Adminhtml\PriceRule;

/**
 * Class Edit
 *
 * @package Paboda\PriceRule\Controller\Adminhtml\PriceRule
 */
class Edit extends PriceRule
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Edit constructor.
     *
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('price_rule_id');
        $model = $this->_objectManager->create(\Paboda\PriceRule\Model\PriceRule::class);

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This price rule no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->_coreRegistry->register('paboda_pricerule_pricerule', $model);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit price rule') : __('New price rule'),
            $id ? __('Edit price rule') : __('New price rule')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Price rules'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? __('Edit price rule %1', $model->getId()) : __('New price rule'));
        return $resultPage;
    }
}
