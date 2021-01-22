<?php
namespace Paboda\Company\Block;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;
use Paboda\Company\Model\CompanyRepository;

class Company extends Template
{
    /**
     * @var \Magento\Framework\Data\Form\FormKey
     */
    protected $formKey;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $_urlBuilder;

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
     * @return Company
     */
    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    /**
     * @return array|mixed|null
     */
    public function getCustomerCompanyData()
    {
        return $this->companyData->getDataByCustomer();
    }

    public function getLogoPath()
    {
        $baseurl =  $this->_storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        return $baseurl . 'customer_company';
    }
}
