<?php
declare(strict_types=1);

namespace Custom\Theme\Block\Product;

use Magento\Framework\View\Element\Template;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Model\Product\Visibility;

class Featured extends Template
{
    protected $collectionFactory;
    protected $visibility;

    public function __construct(
        Template\Context $context,
        CollectionFactory $collectionFactory,
        Visibility $visibility,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->collectionFactory = $collectionFactory;
        $this->visibility = $visibility;
    }

    /**
     * Get featured products collection
     *
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public function getFeaturedProducts()
    {
        $limit = (int)$this->getData('limit') ?: 6;

        $collection = $this->collectionFactory->create()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('featured', 1)
            ->setVisibility($this->visibility->getVisibleInCatalogIds())
            ->addAttributeToSort('created_at', 'desc')
            ->setPageSize($limit);

        return $collection;
    }

    /**
     * Get product image URL
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return string
     */
    public function getProductImage($product): string
    {
        $image = $product->getImage();
        if (!$image || $image === 'no_selection') {
            return $this->getViewFileUrl('images/product-placeholder.svg');
        }
        return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'catalog/product' . $image;
    }

    /**
     * Get product URL
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return string
     */
    public function getProductUrl($product): string
    {
        return $product->getProductUrl();
    }

    /**
     * Get product price HTML
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return string
     */
    public function getProductPrice($product): string
    {
        return $product->getFinalPrice();
    }
}
