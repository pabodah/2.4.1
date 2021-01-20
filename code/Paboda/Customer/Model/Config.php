<?php
namespace Paboda\Customer\Model;

use Magento\Customer\Model\SessionFactory as CustomerSession;
use Paboda\Customer\Model\Config\Source\CompanyAccountValue;

class Config
{
    /**
     * @var CustomerSession
     */
    protected $customerSession;

    /**
     * Config constructor.
     *
     * @param CustomerSession $customerSession
     */
    public function __construct(
        CustomerSession $customerSession
    ) {
        $this->customerSession = $customerSession;
    }

    /**
     * @param null $customer
     * @return bool
     */
    public function isCompanyAccount($customer = null)
    {
        if ($customer == null) {
            $customer = $this->customerSession->create();
        }
        if ($customer instanceof \Magento\Customer\Model\Customer) {
            $companyAccountAttr = $customer->getData('is_company_account');
        } else {
            $companyAccountAttr = $customer->getCustomer()->getIsCompanyAccount();
        }
        if ($companyAccountAttr) {
            return is_string($companyAccountAttr) ?
                (int)$companyAccountAttr === CompanyAccountValue::IS_COMPANY_ACCOUNT :
                (int)$companyAccountAttr->getValue() === CompanyAccountValue::IS_COMPANY_ACCOUNT;
        }
        return false;
    }
}
