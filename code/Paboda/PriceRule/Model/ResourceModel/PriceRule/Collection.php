<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Paboda\PriceRule\Model\ResourceModel\PriceRule;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
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

