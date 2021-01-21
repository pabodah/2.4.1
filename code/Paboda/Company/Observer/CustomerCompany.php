<?php
namespace Paboda\Company\Observer;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\View\Element\Context;
use Paboda\Company\Model\CompanyFactory;

class CustomerCompany implements ObserverInterface
{
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $_request;

    protected $imageUploader;

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

    /**
     * CustomerCompany constructor.
     *
     * @param Context $context
     * @param CustomerRepositoryInterface $customerRepositoryInterface
     * @param CompanyFactory $companyFactory
     */
    public function __construct(
        Context $context,
        CustomerRepositoryInterface $customerRepositoryInterface,
        CompanyFactory $companyFactory
    ) {
        $this->_request = $context->getRequest();
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
        $this->companyFactory = $companyFactory;
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

            $companyModel = $this->companyFactory->create();

            if ((!empty($request)) && (!empty($request['customer']))) {
                if (!empty($request['company'])) {
                    $customerCustomTab = $request['company'];
                    $companyModel->setCustomerId($customerId);
                    $companyModel->setCompanyName($customerCustomTab['company_name']);
                    if (isset($customerCustomTab['company_logo'][0]['file'])) {
                        $companyModel->setCompanyLogo($customerCustomTab['company_logo'][0]['file']);
                    }

                    $companyModel->save();

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
