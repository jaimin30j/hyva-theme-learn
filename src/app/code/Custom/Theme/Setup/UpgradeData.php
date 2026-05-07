<?php
declare(strict_types=1);

namespace Custom\Theme\Setup;

use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;

class UpgradeData implements UpgradeDataInterface
{
    private $eavSetupFactory;
    private $collectionFactory;

    public function __construct(
        EavSetupFactory $eavSetupFactory,
        CollectionFactory $collectionFactory
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->collectionFactory = $collectionFactory;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        // Create 'featured' attribute for products
        if (version_compare($context->getVersion(), '1.0.1') < 0) {
            $eavSetup->addAttribute(
                Product::ENTITY,
                'featured',
                [
                    'group' => 'General',
                    'input' => 'boolean',
                    'type' => 'int',
                    'label' => 'Featured Product',
                    'source' => \Magento\Eav\Model\Entity\Attribute\Source\Boolean::class,
                    'required' => false,
                    'sort_order' => 100,
                    'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                    'is_used_in_grid' => true,
                    'is_visible_in_grid' => true,
                    'is_filterable_in_grid' => true,
                ]
            );
        }

        // Mark first 6 products as featured
        if (version_compare($context->getVersion(), '1.0.2') < 0) {
            $this->markProductsAsFeatured();
        }
    }

    private function markProductsAsFeatured()
    {
        try {
            $collection = $this->collectionFactory->create()
                ->addAttributeToSelect('entity_id')
                ->setPageSize(6);

            foreach ($collection as $product) {
                $product->setData('featured', 1);
                $product->getResource()->saveAttribute($product, 'featured');
            }
        } catch (\Exception $e) {
            // Silently fail if no products exist yet
        }
    }
}

