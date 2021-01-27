<?php
/**
 * Copyright © Paboda Hettiarachchi. All rights reserved.
 */
namespace Paboda\PriceRule\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class PriceRule
 *
 * @package Paboda\PriceRule\Model\ResourceModel
 */
class PriceRule extends AbstractDb
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('custom_pricerule_pricerule', 'price_rule_id');
    }
}
