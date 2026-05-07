<?php
declare(strict_types=1);

namespace Custom\Testimonials\Setup;

use Custom\Testimonials\Model\TestimonialFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    private $testimonialFactory;

    public function __construct(TestimonialFactory $testimonialFactory)
    {
        $this->testimonialFactory = $testimonialFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $testimonials = [
            [
                'name' => 'Sarah Johnson',
                'title' => 'CEO, Tech Solutions Inc.',
                'content' => 'Outstanding quality and exceptional customer service. The products exceeded my expectations and arrived perfectly packaged. Highly recommended!',
                'rating' => 5,
                'sort_order' => 1,
                'is_active' => 1,
            ],
            [
                'name' => 'Michael Chen',
                'title' => 'Marketing Director',
                'content' => 'I\'ve been shopping here for over a year. The consistency in quality and competitive pricing keeps me coming back. Best online store!',
                'rating' => 5,
                'sort_order' => 2,
                'is_active' => 1,
            ],
            [
                'name' => 'Emma Williams',
                'title' => 'Freelance Designer',
                'content' => 'Fast shipping, great prices, and fantastic products. The customer support team was incredibly helpful when I had a question.',
                'rating' => 5,
                'sort_order' => 3,
                'is_active' => 1,
            ],
            [
                'name' => 'David Martinez',
                'title' => 'Business Owner',
                'content' => 'Perfect for bulk orders. They worked with me on pricing and made the whole process smooth. Would definitely use again!',
                'rating' => 4,
                'sort_order' => 4,
                'is_active' => 1,
            ],
            [
                'name' => 'Jessica Anderson',
                'title' => 'Product Manager',
                'content' => 'Best shopping experience I\'ve had in a long time. Everything was as described, packed securely, and delivered on time. Five stars!',
                'rating' => 5,
                'sort_order' => 5,
                'is_active' => 1,
            ],
        ];

        foreach ($testimonials as $testimonialData) {
            $testimonial = $this->testimonialFactory->create();
            $testimonial->setData($testimonialData)->save();
        }

        $setup->endSetup();
    }
}
