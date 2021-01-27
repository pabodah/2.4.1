<?php
/**
 * Copyright © Paboda Hettiarachchi. All rights reserved.
 */

namespace Paboda\PriceRule\Model\ResourceModel\PriceRule;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 *
 * @package Paboda\PriceRule\Model\ResourceModel\PriceRule
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'price_rule_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Paboda\PriceRule\Model\PriceRule::class,
            \Paboda\PriceRule\Model\ResourceModel\PriceRule::class
        );
    }
}
