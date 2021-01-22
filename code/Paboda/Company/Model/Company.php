<?php
namespace Paboda\Company\Model;

use Paboda\Company\Api\Data\CompanyInterface;
use Magento\Framework\Model\AbstractModel;

class Company extends AbstractModel implements CompanyInterface
{
    /**
     * CMS page cache tag.
     */
    const CACHE_TAG = 'paboda_company';

    /**
     * @var string
     */
    protected $_cacheTag = 'paboda_company';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'paboda_company';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init(\Paboda\Company\Model\ResourceModel\Company::class);
    }

    /**
     * Get id
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * Set id
     *
     * @param mixed $id
     * @return Company|AbstractModel|mixed
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * Get customer id
     *
     * @return mixed
     */
    public function getCustomerId()
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    /**
     * Set customer id
     *
     * @param int $customerId
     * @return Company|mixed
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     * Get company name
     *
     * @return mixed
     */
    public function getCompanyName()
    {
        return $this->getData(self::COMPANY_NAME);
    }

    /**
     * Set company name
     *
     * @param string $companyName
     * @return Company
     */
    public function setCompanyName($companyName)
    {
        return $this->setData(self::COMPANY_NAME, $companyName);
    }

    /**
     * Get company logo
     *
     * @return mixed
     */
    public function getCompanyLogo()
    {
        return $this->getData(self::COMPANY_LOGO);
    }

    /**
     * Set company logo
     *
     * @param string $companyLogo
     * @return Company
     */
    public function setCompanyLogo($companyLogo)
    {
        return $this->setData(self::COMPANY_LOGO, $companyLogo);
    }
}
