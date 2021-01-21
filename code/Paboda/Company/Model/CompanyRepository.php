<?php
namespace Paboda\Company\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;
use Paboda\Company\Api\Data\CompanyInterfaceFactory;
use Paboda\Company\Api\CompanyRepositoryInterface;
use Paboda\Company\Model\CompanyFactory as CompanyFactory;
use Paboda\Company\Model\ResourceModel\Company as ResourceCompany;
use Paboda\Company\Model\ResourceModel\Company\CollectionFactory as CompanyCollectionFactory;

class CompanyRepository implements CompanyRepositoryInterface
{
    /**
     * @var ExtensibleDataObjectConverter
     */
    protected $extensibleDataObjectConverter;

    protected $companyFactory;

    protected $resource;

    public function __construct(
        ExtensibleDataObjectConverter $extensibleDataObjectConverter,
        CompanyFactory $companyFactory,
        ResourceCompany $resource
    ) {
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
        $this->companyFactory = $companyFactory;
        $this->resource = $resource;
    }

    public function save(
        \Paboda\Company\Api\Data\CompanyInterface $company
    ) {
        $companyData = $this->extensibleDataObjectConverter->toNestedArray(
            $company,
            [],
            \Paboda\Company\Api\Data\CompanyInterface::class
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

    public function getByCustomer($customer)
    {
        $company = $this->companyFactory->create();
        $this->resource->load($company, $customer, 'customer_id');
        if (!$company->getId()) {
            throw new NoSuchEntityException(__('Variation with the name "%1" exists.', $customer));
        }
        return $company->getId();
    }
}
