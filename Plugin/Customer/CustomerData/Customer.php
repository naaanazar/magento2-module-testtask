<?php

namespace Nakor\TestTask\Plugin\Customer\CustomerData;

use Magento\Framework\Exception\LocalizedException;
use Nakor\TestTask\Helper\Data;
use Magento\Customer\Helper\Session\CurrentCustomer;

class Customer
{
    /**
     * @param CurrentCustomer $currentCustomer
     * @param Data $data
     */
    public function __construct(
        protected CurrentCustomer $currentCustomer,
        protected Data $data
    ) {
    }

    /**
     * Add hobby attribute to customer data
     *
     * @param \Magento\Customer\CustomerData\Customer $subject
     * @param array $result
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @throws LocalizedException
     */
    public function afterGetSectionData(\Magento\Customer\CustomerData\Customer $subject, array $result): array
    {
        if (!$this->currentCustomer->getCustomerId()) {
            return [];
        }

        $result[Data::HOBBY_ATTR_CODE] = $this->data->getHobbyTextValue($this->currentCustomer->getCustomer());

        return $result;
    }
}
