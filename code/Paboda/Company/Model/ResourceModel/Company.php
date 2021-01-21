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
     * Company constructor.
     *
     * @param Context $context
     * @param null $resourcePrefix
     */
    public function __construct(
        Context $context,
        $resourcePrefix = null
    ) {
        parent::__construct($context, $resourcePrefix);
    }

    /**
     * Constructor
     */
    protected function _construct()
    {
        $this->_init('paboda_company', 'id');
    }
}
