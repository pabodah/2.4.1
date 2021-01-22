<?php
namespace Paboda\Company\Model\ResourceModel\Company;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * Define resource model.
     */
    protected function _construct()
    {
        $this->_init(
            \Paboda\Company\Model\Company::class,
            \Paboda\Company\Model\ResourceModel\Company::class
        );
    }

    /**
     * Get company by customer Id
     *
     * @param integer $customer_id
     * @return Collection
     */
    public function getCompanyByCustomer($customer_id)
    {
        return $this->addFieldToFilter('customer_id', $customer_id);
    }
}
