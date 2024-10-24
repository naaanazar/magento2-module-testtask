<?php

declare(strict_types=1);

namespace Nakor\TestTask\Model\Resolver;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\CustomerGraphQl\Model\Customer\ExtractCustomerData;
use Magento\CustomerGraphQl\Model\Customer\GetCustomer;
use Magento\CustomerGraphQl\Model\Customer\UpdateCustomerAccount;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\GraphQl\Model\Query\ContextInterface;
use Nakor\TestTask\Helper\Data;

class UpdateHobby implements ResolverInterface
{
    /**
     * @param GetCustomer $getCustomer
     * @param UpdateCustomerAccount $updateCustomerAccount
     * @param ExtractCustomerData $extractCustomerData
     * @param CustomerRepositoryInterface $customerRepository
     * @param Data $data
     */
    public function __construct(
        protected GetCustomer $getCustomer,
        protected UpdateCustomerAccount $updateCustomerAccount,
        protected ExtractCustomerData $extractCustomerData,
        protected CustomerRepositoryInterface $customerRepository,
        protected Data $data
    ) {
    }

    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        /** @var ContextInterface $context */
        if (false === $context->getExtensionAttributes()->getIsCustomer()) {
            throw new GraphQlAuthorizationException(__('The current customer isn\'t authorized.'));
        }

        if (!isset($args['input'][Data::HOBBY_ATTR_CODE])) {
            throw new GraphQlInputException(__('No hobby provided.'));
        }

        if (!$this->data->isValidHobbyOption($args['input'][Data::HOBBY_ATTR_CODE])) {
            throw new GraphQlInputException(__('Incorrect Hobby value.'));
        }

        $customer = $this->getCustomer->execute($context);

        $customer->setCustomAttribute(Data::HOBBY_ATTR_CODE, $args['input'][Data::HOBBY_ATTR_CODE]);
        $this->customerRepository->save($customer);

        return [$customer];
    }
}
