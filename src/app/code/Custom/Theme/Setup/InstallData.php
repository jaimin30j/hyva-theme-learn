<?php
declare(strict_types=1);

namespace Custom\Theme\Setup;

use Magento\Cms\Model\BlockFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Store\Model\StoreManagerInterface;

class InstallData implements InstallDataInterface
{
    private $blockFactory;
    private $storeManager;

    public function __construct(
        BlockFactory $blockFactory,
        StoreManagerInterface $storeManager
    ) {
        $this->blockFactory = $blockFactory;
        $this->storeManager = $storeManager;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $store = $this->storeManager->getDefaultStoreView();
        $storeId = (int) $store->getId();

        // Hero Banner Block
        $this->createBlock(
            'home-hero-banner',
            'Home - Hero Banner',
            '<div class="hero-banner-content">
                <h2>Welcome to Our Premium Store</h2>
                <p>Discover the finest selection of quality products curated just for you</p>
            </div>',
            $storeId
        );

        // Features Block
        $this->createBlock(
            'home-features',
            'Home - Features Section',
            '<div class="features-content">
                <h3>Why shop with us?</h3>
                <ul>
                    <li>Free shipping on orders over $50</li>
                    <li>30-day money back guarantee</li>
                    <li>24/7 customer support</li>
                </ul>
            </div>',
            $storeId
        );

        // CTA Block
        $this->createBlock(
            'home-cta-section',
            'Home - Call To Action',
            '<div class="cta-content">
                <h2>Exclusive Offers This Week</h2>
                <p>Get up to 40% off on selected items. Limited time only!</p>
            </div>',
            $storeId
        );

        // Footer Info Block
        $this->createBlock(
            'home-footer-info',
            'Home - Footer Information',
            '<div class="footer-info-content">
                <h3>Contact Information</h3>
                <p><strong>Email:</strong> support@example.com</p>
                <p><strong>Phone:</strong> 1-800-EXAMPLE</p>
                <p><strong>Hours:</strong> Monday - Friday, 9AM - 5PM EST</p>
            </div>',
            $storeId
        );

        $setup->endSetup();
    }

    private function createBlock(string $identifier, string $title, string $content, int $storeId)
    {
        $block = $this->blockFactory->create();

        // Check if block already exists
        $existingBlock = $block->getCollection()
            ->addFieldToFilter('identifier', $identifier)
            ->getFirstItem();

        if (!$existingBlock->getId()) {
            $block->setTitle($title)
                ->setIdentifier($identifier)
                ->setContent($content)
                ->setIsActive(1)
                ->setStores([$storeId])
                ->save();
        }
    }
}
