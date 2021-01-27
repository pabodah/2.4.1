<?php
/**
 * Copyright © Paboda Hettiarachchi. All rights reserved.
 */

namespace Paboda\PriceRule\Controller\Adminhtml\PriceRule;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Paboda\PriceRule\Api\Data\PriceRuleInterface;
use Paboda\PriceRule\Controller\Adminhtml\PriceRule;
use Paboda\PriceRule\Model\PriceRuleFactory;
use Paboda\PriceRule\Model\ResourceModel\PriceRule as PriceRuleResource;

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
     * @var PriceRuleFactory
     */
    protected $priceRuleFactory;

    /**
     * @var PriceRuleResource
     */
    protected $priceRuleResource;

    /**
     * Edit constructor.
     *
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     * @param PriceRuleFactory $priceRuleFactory
     * @param PriceRuleResource $priceRuleResource
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        PriceRuleFactory $priceRuleFactory,
        PriceRuleResource $priceRuleResource
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context, $coreRegistry);
        $this->priceRuleFactory = $priceRuleFactory;
        $this->priceRuleResource = $priceRuleResource;
    }

    /**
     * Edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam(PriceRuleInterface::PRICE_RULE_ID);
        $model = $this->priceRuleFactory->create();

        if ($id) {
            $this->priceRuleResource->load($model, $id);

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
        $resultPage->getConfig()
            ->getTitle()
            ->prepend($model->getId() ? __('Edit price rule %1', $model->getId()) : __('New price rule'));
        return $resultPage;
    }
}
