<?php
namespace Paboda\Company\Api\Data;

interface CompanyInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    const ID = 'id';
    const CUSTOMER_ID = 'customer_id';
    const COMPANY_NAME = 'company_name';
    const COMPANY_LOGO = 'company_logo';

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param $id
     * @return mixed
     */
    public function setId($id);

    /**
     * @return mixed
     */
    public function getCustomerId();

    /**
     * @param $customerId
     * @return mixed
     */
    public function setCustomerId($customerId);

    /**
     * @return mixed
     */
    public function getCompanyName();

    /**
     * @param $companyName
     * @return mixed
     */
    public function setCompanyName($companyName);

    /**
     * @return mixed
     */
    public function getCompanyLogo();

    /**
     * @param $companyLogo
     * @return mixed
     */
    public function setCompanyLogo($companyLogo);
}
