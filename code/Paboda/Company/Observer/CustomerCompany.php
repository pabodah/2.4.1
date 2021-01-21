<?php
namespace Paboda\Company\Observer;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\View\Element\Context;
use Paboda\Company\Api\Data\CompanyInterface;
use Paboda\Company\Model\CompanyFactory;
use Paboda\Company\Model\CompanyRepository;

class CustomerCompany implements ObserverInterface
{
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $_request;

    /**
     * @var
     */
    protected $imageUploader;

    /**
     * @var CompanyRepository
     */
    protected $companyRepository;

    /**
     * @var \Paboda\Company\Model\Company
     */
    protected $companyFactory;

    protected $companyInterface;

    /**
     * CustomerCompany constructor.
     *
     * @param Context $context
     * @param CustomerRepositoryInterface $customerRepositoryInterface
     * @param CompanyFactory $companyFactory
     * @param CompanyRepository $companyRepository
     * @param CompanyInterface $companyInterface
     */
    public function __construct(
        Context $context,
        CompanyFactory $companyFactory,
        CompanyRepository $companyRepository,
        CompanyInterface $companyInterface
    ) {
        $this->_request = $context->getRequest();
        $this->companyFactory = $companyFactory;
        $this->companyRepository = $companyRepository;
        $this->companyInterface = $companyInterface;
    }

    /**
     * @param EventObserver $observer
     * @return $this|void
     */
    public function execute(EventObserver $observer)
    {
        try {
            $customer = $observer->getCustomerDataObject();
            $customerId = $customer->getId();
            $request = $this->_request->getParams();

            $companyData = $this->companyRepository->getByCustomer($customerId);

            if ((!empty($request)) && (!empty($request['customer']))) {
                if (!empty($request['company'])) {
                    $customerCustomTab = $request['company'];

                    if ($companyData) {
                        $data['id'] = $companyData;
                    }

                    $data['company_name'] = $customerCustomTab['company_name'];

                    /*if (isset($customerCustomTab['company_logo'][0]['file'])) {
                        $data['company_logo'] = $customerCustomTab['company_logo'][0]['file'];
                    } elseif (!isset($customerCustomTab['company_logo'])) {
                        $data['company_logo'] = null;
                    }*/

                    $this->companyInterface->setId($companyData);
                    $this->companyInterface->setCustomerId($customerId);
                    $this->companyInterface->setCompanyName($customerCustomTab['company_name']);

                    //if (isset($customerCustomTab['company_logo'][0]['file'])) {
                        if (isset($customerCustomTab['company_logo'][0]['name']) && isset($customerCustomTab['company_logo'][0]['tmp_name'])) {
                            $data['image'] = $customerCustomTab['company_logo'][0]['name'];
                            $this->imageUploader = \Magento\Framework\App\ObjectManager::getInstance()->get(
                                'Paboda\Company\CompanyImageUpload'
                            );
                            $this->imageUploader->moveFileFromTmp($data['image']);
                        } elseif (isset($customerCustomTab['company_logo']) && !isset($data['company_logo'][0]['tmp_name'])) {
                            $data['image'] = $customerCustomTab['company_logo'][0]['image'];
                        } else {
                            $data['image'] = '';
                        }
                    /*} else {
                        $data['image'] = '';
                    }*/

                    $this->companyInterface->setCompanyLogo($data['image']);

                    $this->companyRepository->save($this->companyInterface);
                }
            }
            return $this;
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }
}
