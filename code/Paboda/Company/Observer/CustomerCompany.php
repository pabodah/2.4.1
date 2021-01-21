<?php
namespace Paboda\Company\Observer;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\View\Element\Context;
use Paboda\Company\Model\CompanyFactory;
use Paboda\Company\Model\CompanyRepository;
use Paboda\Company\Api\Data\CompanyInterface;

class CustomerCompany implements ObserverInterface
{
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $_request;

    protected $imageUploader;

    protected $companyRepository;

    /**
     * @var
     */
    protected $_layout;

    /**
     * @var CustomerRepositoryInterface
     */
    protected $_customerRepositoryInterface;

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
        CustomerRepositoryInterface $customerRepositoryInterface,
        CompanyFactory $companyFactory,
        CompanyRepository $companyRepository,
        CompanyInterface $companyInterface
    ) {
        $this->_request = $context->getRequest();
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
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

            $model = $this->companyFactory->create();

            $check = $this->companyRepository->getByCustomer($customerId);

            if ($check) {
                $id = $check;
            }

            if ((!empty($request)) && (!empty($request['customer']))) {
                if (!empty($request['company'])) {
                    $customerCustomTab = $request['company'];

                    if ($id) {
                        $data['id'] = $id;
                    }

                    $data['company_name'] = $customerCustomTab['company_name'];

                    if (isset($customerCustomTab['company_logo'][0]['file'])) {
                        $data['company_logo'] = $customerCustomTab['company_logo'][0]['file'];
                    }

                    $this->companyInterface->setId($id);
                    $this->companyInterface->setCustomerId($customerId);
                    $this->companyInterface->setCompanyName($customerCustomTab['company_name']);

                    if (isset($customerCustomTab['company_logo'][0]['file'])) {
                        $this->companyInterface->setCompanyLogo($customerCustomTab['company_logo'][0]['file']);
                    }

                    $this->companyRepository->save($this->companyInterface);

                    //$companyModel->setId($customerId);
                    /*$companyModel->setCustomerId($customerId);
                    $companyModel->setCompanyName($customerCustomTab['company_name']);

                    if (isset($customerCustomTab['company_logo'][0]['file'])) {
                        $companyModel->setCompanyLogo($customerCustomTab['company_logo'][0]['file']);
                    }

                    $companyModel->save();*/

                    if (isset($customerCustomTab['company_logo'][0]['name']) && isset($customerCustomTab['company_logo'][0]['tmp_name'])) {
                        $data['image'] =$customerCustomTab['company_logo'][0]['name'];
                        $this->imageUploader = \Magento\Framework\App\ObjectManager::getInstance()->get(
                            'Paboda\Company\HelloWorldImageUpload'
                        );
                        $this->imageUploader->moveFileFromTmp($data['image']);
                    } elseif (isset($data['company_logo'][0]['image']) && !isset($data['status'][0]['tmp_name'])) {
                        $data['image'] = $data['company_logo'][0]['image'];
                    } else {
                        $data['image'] = null;
                    }
                }
            }
            return $this;
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }
}
