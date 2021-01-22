<?php
namespace Paboda\Company\Block;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;
use Paboda\Company\Model\CompanyRepository;

class Company extends Template
{
    const IMAGE_PATH = "customer_company";

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var CompanyRepository
     */
    protected $companyData;

    /**
     * Company constructor.
     *
     * @param Template\Context $context
     * @param CompanyRepository $companyData
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        CompanyRepository $companyData,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->companyData = $companyData;
    }

    /**
     * Get company data
     *
     * @return array|mixed|null
     */
    public function getCompanyData()
    {
        return $this->companyData->getDataByCustomer();
    }

    /**
     * Get path for logo
     *
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getLogoPath()
    {
        $baseurl =  $this->_storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        return $baseurl . self::IMAGE_PATH;
    }
}
