<?php
namespace Paboda\Company\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

class Company extends AbstractDb
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * Constructor
     */
    protected function _construct()
    {
        $this->_init('paboda_company', 'id');
    }
}
