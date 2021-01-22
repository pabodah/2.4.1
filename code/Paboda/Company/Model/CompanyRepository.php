<?php
namespace Paboda\Company\Model;

use Magento\Customer\Model\Session;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Paboda\Company\Api\CompanyRepositoryInterface;
use Paboda\Company\Api\Data\CompanyInterface;
use Paboda\Company\Model\ResourceModel\Company as ResourceCompany;

class CompanyRepository implements CompanyRepositoryInterface
{
    /**
     * @var ExtensibleDataObjectConverter
     */
    protected $extensibleDataObjectConverter;

    /**
     * @var CompanyFactory
     */
    protected $companyFactory;

    /**
     * @var ResourceCompany
     */
    protected $resource;

    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * CompanyRepository constructor.
     *
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     * @param CompanyFactory $companyFactory
     * @param ResourceCompany $resource
     * @param Session $customerSession
     */
    public function __construct(
        ExtensibleDataObjectConverter $extensibleDataObjectConverter,
        CompanyFactory $companyFactory,
        ResourceCompany $resource,
        Session $customerSession
    ) {
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
        $this->companyFactory = $companyFactory;
        $this->resource = $resource;
        $this->customerSession = $customerSession;
    }

    /**
     * @param CompanyInterface $company
     * @return mixed
     * @throws CouldNotSaveException
     */
    public function save(
        CompanyInterface $company
    ) {
        $companyData = $this->extensibleDataObjectConverter->toNestedArray(
            $company,
            [],
            CompanyInterface::class
        );

        $companyModel = $this->companyFactory->create()->setData($companyData);

        try {
            $this->resource->save($companyModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the variations: %1',
                $exception->getMessage()
            ));
        }
        return $companyModel->getDataModel();
    }

    /**
     * Get Company by Customer
     *
     * @param $customer
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getByCustomer($customer)
    {
        $company = $this->companyFactory->create();
        $this->resource->load($company, $customer, 'customer_id');
        if (!$company->getId()) {
            return null;
        }
        return $company->getId();
    }

    /**
     * @return array|mixed|null
     */
    public function getDataByCustomer()
    {
        $company = $this->companyFactory->create();
        $this->resource->load($company, $this->customerSession->getId(), 'customer_id');
        if (!$company->getId()) {
            return null;
        }
        return $company->getData();
    }
}
