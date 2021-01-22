<?php
namespace Paboda\Company\Plugin\Customer\Model\Customer;

use Magento\Customer\Model\Session;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Paboda\Company\Model\ResourceModel\Company\Collection;

class CompanyDataProvider
{
    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * @var Collection
     */
    protected $customerCompany;
    /**
     * @var array
     */
    public $_storeManager;

    /**
     * CompanyDataProvider constructor.
     * @param Session $customerSession
     * @param Collection $customerCompany
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Session $customerSession,
        Collection $customerCompany,
        StoreManagerInterface $storeManager
    ) {
        $this->customerSession = $customerSession;
        $this->customerCompany = $customerCompany;
        $this->_storeManager=$storeManager;
    }

    /**
     * Get data
     *
     * @param array $source
     * @param array $response
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function afterGetData($source, $response)
    {
        $arr = [];
        $id = 0;
        if (!empty($response)) {
            $ids = $source->getAllIds();
            $id = $ids[0];
        }

        $baseurl =  $this->_storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);

        if (!empty($response)) {
            $customerCompanyArr = $this->customerCompany
                ->getCompanyByCustomer($response[$id]['customer_id'])
                ->getData();

            foreach ($customerCompanyArr as $arrItem) {
                $arr['company_name'] = $arrItem['company_name'];

                if ($arrItem['company_logo']) {
                    $img = [];
                    $img[0]['image'] = $arrItem['company_logo'];
                    $img[0]['url'] = $baseurl . 'customer_company/' . $arrItem['company_logo'];
                    $arr['company_logo'] = $img;
                } else {
                    $arr['company_logo'] = '';
                }
            }

            if (isset($response[$id]['customer_id']) && isset($arr['company_name'])) {
                $response[$id]['company']['company_name'] = $arr['company_name'];
                $response[$id]['company']['company_logo'] = $arr['company_logo'];
            }
        }
        return $response;
    }
}
