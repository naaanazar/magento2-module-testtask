<?php

namespace Nakor\TestTask\Block\Account\Hobby;

use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Nakor\TestTask\Helper\Data;

class Edit extends Template
{
    /**
     * @param Context $context
     * @param Data $dataHelper
     * @param CurrentCustomer $currentCustomer
     * @param array $data
     */
    public function __construct(
        Context $context,
        protected Data $dataHelper,
        protected CurrentCustomer $currentCustomer,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Get hobby options
     *
     * @return array
     * @throws LocalizedException
     */
    public function getHobbyOptions(): array
    {
        return $this->dataHelper->getHobbyOptions();
    }

    /**
     * Get Customer Hobby Value
     *
     * @return mixed
     */
    public function getCustomerHobbyValue(): mixed
    {
        $hobbyAttr = $this->currentCustomer->getCustomer()->getCustomAttribute(Data::HOBBY_ATTR_CODE);
        return $hobbyAttr ? $hobbyAttr->getValue() : '';
    }

    /**
     * Get Form Action Url
     *
     * @return string
     */
    public function getFormActionUrl(): string
    {
        return $this->getUrl('testtask/hobby/editpost');
    }
}
