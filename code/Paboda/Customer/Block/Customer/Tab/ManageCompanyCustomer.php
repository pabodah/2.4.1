<?php
namespace Paboda\Customer\Block\Customer\Tab;

use Magento\Customer\Block\Account\SortLinkInterface;
use Magento\Framework\App\DefaultPathInterface;
use Magento\Framework\View\Element\Html\Link\Current;
use Magento\Framework\View\Element\Template\Context;
use Paboda\Customer\Model\Config;

class ManageCompanyCustomer extends Current implements SortLinkInterface
{
    /**
     * @var Config
     */
    private $config;

    /**
     * SubChangePassword constructor.
     *
     * @param Context $context
     * @param DefaultPathInterface $defaultPath
     * @param Config $config
     * @param array $data
     */
    public function __construct(
        Context $context,
        DefaultPathInterface $defaultPath,
        Config $config,
        array $data = []
    ) {
        $this->config = $config;
        parent::__construct($context, $defaultPath, $data);
    }

    /**
     * Produce and return block's html output
     *
     * If logged in is sub-user will show this tab
     *
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function toHtml()
    {
        if ($this->config->isCompanyAccount()) {
            return parent::toHtml();
        }
        return '';
    }

    /**
     * Get sort order for block.
     *
     * @return int
     */
    public function getSortOrder()
    {
        return $this->getData(self::SORT_ORDER);
    }
}
