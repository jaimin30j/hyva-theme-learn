<?php
declare(strict_types=1);

namespace Custom\Testimonials\Model\ResourceModel\Testimonial;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'testimonial_id';

    protected function _construct()
    {
        $this->_init(
            \Custom\Testimonials\Model\Testimonial::class,
            \Custom\Testimonials\Model\ResourceModel\Testimonial::class
        );
    }

    /**
     * Filter by active status
     *
     * @return $this
     */
    public function addActiveFilter()
    {
        $this->addFieldToFilter('is_active', 1);
        return $this;
    }

    /**
     * Sort by sort order
     *
     * @return $this
     */
    public function addOrderBySort()
    {
        $this->addOrder('sort_order', self::SORT_ORDER_ASC);
        return $this;
    }
}
