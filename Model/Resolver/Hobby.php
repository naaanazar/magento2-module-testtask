<?php

declare(strict_types=1);

namespace Nakor\TestTask\Model\Resolver;

use Magento\CustomerGraphQl\Model\Customer\GetCustomer;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\GraphQl\Model\Query\ContextInterface;
use Nakor\TestTask\Helper\Data;

class Hobby implements ResolverInterface
{
    /**
     * @param GetCustomer $getCustomer
     * @param Data $data
     */
    public function __construct(
        protected GetCustomer $getCustomer,
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

        return $this->data->getHobbyTextValue($this->getCustomer->execute($context));
    }
}
