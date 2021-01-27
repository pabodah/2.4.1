<?php
/**
 * Copyright © Paboda Hettiarachchi. All rights reserved.
 */

namespace Paboda\PriceRule\Controller\Adminhtml\PriceRule;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Framework\Registry;
use Paboda\PriceRule\Controller\Adminhtml\PriceRule;

/**
 * Class NewAction
 *
 * @package Paboda\PriceRule\Controller\Adminhtml\PriceRule
 */
class NewAction extends PriceRule
{
    /**
     * @var ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param ForwardFactory $resultForwardFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        ForwardFactory $resultForwardFactory
    ) {
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * New action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Forward $resultForward */
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}
