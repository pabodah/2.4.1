<?php
/**
 * Copyright © Paboda Hettiarachchi. All rights reserved.
 */

namespace Paboda\PriceRule\Controller\Adminhtml\PriceRule;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Paboda\PriceRule\Api\Data\PriceRuleInterface;
use Paboda\PriceRule\Api\PriceRuleRepositoryInterface;
use Paboda\PriceRule\Controller\Adminhtml\PriceRule;

/**
 * Class Delete
 *
 * @package Paboda\PriceRule\Controller\Adminhtml\PriceRule
 */
class Delete extends PriceRule
{
    /**
     * @var PriceRuleRepositoryInterface
     */
    protected $priceRuleRepository;

    /**
     * Delete constructor.
     *
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PriceRuleRepositoryInterface $priceRuleRepository
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PriceRuleRepositoryInterface $priceRuleRepository
    ) {
        parent::__construct($context, $coreRegistry);
        $this->priceRuleRepository = $priceRuleRepository;
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        $id = $this->getRequest()->getParam(PriceRuleInterface::PRICE_RULE_ID);
        if ($id) {
            try {
                $this->priceRuleRepository->deleteById($id);
                $this->messageManager->addSuccessMessage(__('You deleted the price rule.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', [PriceRuleInterface::PRICE_RULE_ID => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a price rule to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
