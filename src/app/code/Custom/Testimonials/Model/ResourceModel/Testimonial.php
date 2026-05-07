<?php
declare(strict_types=1);

namespace Custom\Testimonials\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Testimonial extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('custom_testimonials', 'testimonial_id');
    }
}
