<?php
namespace Paboda\Company\Api\Data;

interface CompanyInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    const ID = 'id';
    const CUSTOMER_ID = 'customer_id';
    const COMPANY_NAME = 'company_name';
    const COMPANY_LOGO = 'company_logo';

    /**
     * Get id
     *
     * @return mixed
     */
    public function getId();

    /**
     * Set id
     *
     * @param int $id
     * @return mixed
     */
    public function setId($id);

    /**
     * Get customer id
     *
     * @return mixed
     */
    public function getCustomerId();

    /**
     * Set customer id
     *
     * @param int $customerId
     * @return mixed
     */
    public function setCustomerId($customerId);

    /**
     * Get company name
     *
     * @return mixed
     */
    public function getCompanyName();

    /**
     * Set company name
     *
     * @param string $companyName
     * @return mixed
     */
    public function setCompanyName($companyName);

    /**
     * Get company logo
     *
     * @return mixed
     */
    public function getCompanyLogo();

    /**
     * Set company logo
     *
     * @param string $companyLogo
     * @return mixed
     */
    public function setCompanyLogo($companyLogo);
}
