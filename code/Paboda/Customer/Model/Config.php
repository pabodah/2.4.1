<?php
namespace Paboda\Customer\Model;

use Paboda\Customer\Model\Config\Source\CompanyAccountValue;
use Magento\Customer\Model\Session;

class Config
{
    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * Config constructor.
     *
     * @param Session $customerSession
     */
    public function __construct(
        Session $customerSession
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
            $customer = $this->customerSession->getCustomer();
        }
        if ($customer instanceof \Magento\Customer\Model\Customer) {
            $companyAccountAttr = $customer->getData('is_company_account');
        } else {
            $companyAccountAttr = $customer->getCustomAttribute('is_company_account');
        }
        if ($companyAccountAttr) {
            return is_string($companyAccountAttr) ?
                (int)$companyAccountAttr === CompanyAccountValue::IS_COMPANY_ACCOUNT :
                (int)$companyAccountAttr->getValue() === CompanyAccountValue::IS_COMPANY_ACCOUNT;
        }
        return false;
    }
}
