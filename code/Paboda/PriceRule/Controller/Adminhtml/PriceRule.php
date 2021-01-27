<?php
/**
 * Copyright © Paboda Hettiarachchi. All rights reserved.
 */

namespace Paboda\PriceRule\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;

/**
 * Class PriceRule
 *
 * @package Paboda\PriceRule\Controller\Adminhtml
 */
abstract class PriceRule extends Action
{

    const ADMIN_RESOURCE = 'Paboda_PriceRule::top_level';
    protected $_coreRegistry;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry
    ) {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    /**
     * Init page
     *
     * @param $resultPage
     * @return mixed
     */
    public function initPage($resultPage)
    {
        $resultPage->setActiveMenu(self::ADMIN_RESOURCE)
            ->addBreadcrumb(__('Paboda'), __('Paboda'))
            ->addBreadcrumb(__('Price rule'), __('Price rule'));
        return $resultPage;
    }
}
