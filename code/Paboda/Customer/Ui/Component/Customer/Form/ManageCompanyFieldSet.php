<?php
namespace Paboda\Customer\Ui\Component\Customer\Form;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\View\Element\ComponentVisibilityInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Form\Fieldset;
use Paboda\Customer\Model\Config;

class ManageCompanyFieldSet extends Fieldset implements ComponentVisibilityInterface
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @param CustomerRepositoryInterface $customerRepository
     * @param ContextInterface $context
     * @param Config $config
     * @param array $components
     * @param array $data
     */
    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        ContextInterface $context,
        Config $config,
        array $components = [],
        array $data = []
    ) {
        $this->customerRepository = $customerRepository;
        $this->context = $context;
        $this->config = $config;
        parent::__construct($context, $components, $data);
    }

    /**
     * Can show manage company tab in tabs or not
     *
     * Will return false for not is company account
     *
     * @return boolean
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function isComponentVisible(): bool
    {
        $customerId = $this->context->getRequestParam('id');
        if ($customerId) {
            $customer = $this->customerRepository->getById((int) $customerId);
            return $this->config->isCompanyAccount($customer);
        }
        return false;
    }
}
