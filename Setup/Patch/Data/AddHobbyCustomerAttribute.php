<?php

declare(strict_types=1);

namespace Nakor\TestTask\Setup\Patch\Data;

use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Validator\ValidateException;
use Nakor\TestTask\Helper\Data;
use Magento\Customer\Model\ResourceModel\Attribute as AttributeResourceModel;
use Magento\Eav\Model\Config as EavConfig;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Model\Entity\Attribute\Source\Table;
use Magento\Customer\Model\Customer;

class AddHobbyCustomerAttribute implements DataPatchInterface
{
    /**
     * @param AttributeResourceModel $attributeResourceModel
     * @param EavConfig $eavConfig
     * @param EavSetupFactory $eavSetupFactory
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
        protected AttributeResourceModel $attributeResourceModel,
        protected EavConfig $eavConfig,
        protected EavSetupFactory $eavSetupFactory,
        protected ModuleDataSetupInterface $moduleDataSetup
    ) {
    }

    /**
     * Add hobby attribute
     *
     * @return void
     * @throws AlreadyExistsException
     * @throws LocalizedException
     * @throws ValidateException
     */
    public function apply(): void
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->addAttribute(
            Customer::ENTITY,
            Data::HOBBY_ATTR_CODE,
            [
                'type' => 'int',
                'label' => 'Hobby',
                'input' => 'select',
                'source' => Table::class,
                'frontend' => '',
                'required' => false,
                'default' => null,
                'user_defined' => true,
                'unique' => false,
                'visible' => true,
                'system' => false,
                'group' => 'General',
                'position' => 200,
                'sort_order' => 200,
                'option' => ['values' => [
                    'Yoga',
                    'Traveling',
                    'Hiking',
                ],
                ],
            ]
        );

        $attribute = $this->eavConfig->getAttribute(
            Customer::ENTITY,
            Data::HOBBY_ATTR_CODE
        );
        $attribute->setData('used_in_forms', ['adminhtml_customer']);

        $this->attributeResourceModel->save($attribute);
    }

    /**
     * Get aliases (previous names) for the patch.
     *
     * @return string[]
     */
    public function getAliases(): array
    {
        return [];
    }

    /**
     * Get Dependencies
     *
     * @return array|string[]
     */
    public static function getDependencies(): array
    {
        return [];
    }
}
