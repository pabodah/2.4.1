<?php
namespace Paboda\Company\Model;

use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\Session;
use Paboda\Company\Api\CompanyInterface;

class CompanyData implements CompanyInterface
{
    /**
     * @var CompanyFactory
     */
    protected $company;

    /**
     * @var CustomerFactory
     */
    protected $customerFactory;

    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * CompanyData constructor.
     *
     * @param Session $customerSession
     * @param CustomerFactory $customerFactory
     * @param CompanyFactory $company
     */
    public function __construct(
        Session $customerSession,
        CustomerFactory $customerFactory,
        CompanyFactory $company
    ) {
        $this->customerSession = $customerSession;
        $this->customerFactory = $customerFactory;
        $this->company = $company;
    }

    /**
     * @param $data
     * @return mixed|void
     * @throws \Exception
     */
    public function saveCompanyData($data)
    {
        $customerId = $this->getCustomer()->getId();
        $companyModel = $this->company->create();
        $postArr = explode(',', $data['company_name']);

        $collection = $companyModel->getCollection()->addFieldToFilter('customer_id', $customerId);
        if ($collection->getSize() > 1) {
            $savedDataArr = $collection->getData();
            $ingrediantIds = [];
            foreach ($savedDataArr as $savedArr) {
                $ingrediantIds[] = $savedArr['company_name'];
            }
        }
        if (isset($ingrediantIds)) {
            $companyArr = array_unique(array_merge($ingrediantIds, $postArr));
        } else {
            $companyArr = $postArr;
        }
        $this->deleteDislikeData($companyModel);
        $companyModel = $this->company->create();
        if (!empty($data['ingredient_id'])) {
            foreach ($companyArr as $dislike) {
                $companyModel->setCustomerId($customerId);
                $companyModel->setIngredientId($dislike);
                $companyModel->setStatus(1);
                $companyModel->save();
                $companyModel->unsetData();
            }
        }
    }

    /**
     * @param $companyModel
     * @return bool
     */
    public function deleteDislikeData($companyModel)
    {
        $customerId = $this->getCustomer()->getId();
        $collection = $companyModel->getCollection()->addFieldToFilter('customer_id', $customerId);
        if ($collection->getSize() > 1) {
            foreach ($collection as $collectionItem) {
                $companyModel = $companyModel->load($collectionItem->getId());
                $companyModel->delete();
                $companyModel->unsetData();
            }
            return true;
        }
    }

    /**
     * @return int|null
     */
    public function getCustomerId()
    {
        return $this->getCustomer()->getId();
    }
    /**
     * @return Session
     */
    public function getCustomer()
    {
        if ($this->customerSession->isLoggedIn()) {
            return $this->customerSession;
        }
    }

    /**
     * @return mixed
     */
    public function filterCompanyData()
    {
        if (!empty($this->getCustomer())) {
            $customerId = $this->getCustomerId();
            $customerCompany =  $this->company->create()->getCollection()
                ->addFieldToFilter('main_table.customer_id', $customerId);
            $customerCompany->getSelect();

            return $customerCompany->getData();
        }
    }
}
