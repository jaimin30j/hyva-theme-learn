<?php
declare(strict_types=1);

namespace Custom\Testimonials\Block;

use Magento\Framework\View\Element\Template;
use Custom\Testimonials\Model\ResourceModel\Testimonial\CollectionFactory;

class Testimonials extends Template
{
    protected $collectionFactory;

    public function __construct(
        Template\Context $context,
        CollectionFactory $collectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Get active testimonials collection
     *
     * @return \Custom\Testimonials\Model\ResourceModel\Testimonial\Collection
     */
    public function getTestimonials()
    {
        $collection = $this->collectionFactory->create();
        $collection->addActiveFilter();
        $collection->addOrderBySort();
        return $collection;
    }

    /**
     * Get testimonial image URL
     *
     * @param string $imagePath
     * @return string
     */
    public function getImageUrl(string $imagePath): string
    {
        if (empty($imagePath)) {
            return $this->getViewFileUrl('images/testimonial-placeholder.svg');
        }
        return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'testimonials/' . $imagePath;
    }

    /**
     * Get star rating HTML
     *
     * @param int $rating
     * @return string
     */
    public function getStarRating(int $rating): string
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            $stars .= $i <= $rating ? '★' : '☆';
        }
        return $stars;
    }
}
