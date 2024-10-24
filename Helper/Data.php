<?php

declare(strict_types=1);

namespace Nakor\TestTask\Helper;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Config as EavConfig;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Exception\LocalizedException;

class Data extends AbstractHelper
{
    public const string HOBBY_ATTR_CODE = 'hobby';

    /**
     * @param Context $context
     * @param EavConfig $eavConfig
     */
    public function __construct(
        Context $context,
        protected EavConfig $eavConfig
    ) {
        parent::__construct($context);
    }

    /**
     * Get Hobby Options
     *
     * @return array
     * @throws LocalizedException
     */
    public function getHobbyOptions(): array
    {
        return (array) $this->eavConfig->getAttribute(Customer::ENTITY, self::HOBBY_ATTR_CODE)
            ->getOptions();
    }

    /**
     * Get Hobby Label
     *
     * @param CustomerInterface $customer
     * @return string|null
     * @throws LocalizedException
     */
    public function getHobbyTextValue(CustomerInterface $customer): string|null
    {
        $hobby = $customer->getCustomAttribute(Data::HOBBY_ATTR_CODE);

        if (!$hobby) {
            return null;
        }

        $attribute = $this->eavConfig->getAttribute(Customer::ENTITY, self::HOBBY_ATTR_CODE);

        return (string) $attribute->getSource()->getOptionText($hobby->getValue());
    }

    /**
     * Check if the provided hobby value is valid.
     *
     * @param mixed $hobbyValue
     * @return bool
     * @throws LocalizedException
     */
    public function isValidHobbyOption(mixed $hobbyValue): bool
    {
        foreach ($this->getHobbyOptions() as $option) {
            if ($option->getValue() == $hobbyValue) {
                return true;
            }
        }

        return false;
    }
}
