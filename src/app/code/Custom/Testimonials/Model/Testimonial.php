<?php
declare(strict_types=1);

namespace Custom\Testimonials\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb as ResourceAbstractDb;

class Testimonial extends AbstractModel
{
    protected $_idFieldName = 'testimonial_id';

    protected function _construct()
    {
        $this->_init(\Custom\Testimonials\Model\ResourceModel\Testimonial::class);
    }

    /**
     * Get testimonial name
     *
     * @return string
     */
    public function getName(): string
    {
        return (string)$this->getData('name');
    }

    /**
     * Set testimonial name
     *
     * @param string $name
     * @return $this
     */
    public function setName(string $name)
    {
        return $this->setData('name', $name);
    }

    /**
     * Get testimonial title
     *
     * @return string
     */
    public function getTitle(): string
    {
        return (string)$this->getData('title');
    }

    /**
     * Set testimonial title
     *
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title)
    {
        return $this->setData('title', $title);
    }

    /**
     * Get testimonial content
     *
     * @return string
     */
    public function getContent(): string
    {
        return (string)$this->getData('content');
    }

    /**
     * Set testimonial content
     *
     * @param string $content
     * @return $this
     */
    public function setContent(string $content)
    {
        return $this->setData('content', $content);
    }

    /**
     * Get rating
     *
     * @return int
     */
    public function getRating(): int
    {
        return (int)$this->getData('rating');
    }

    /**
     * Set rating
     *
     * @param int $rating
     * @return $this
     */
    public function setRating(int $rating)
    {
        return $this->setData('rating', $rating);
    }

    /**
     * Get image path
     *
     * @return string
     */
    public function getImagePath(): string
    {
        return (string)$this->getData('image_path');
    }

    /**
     * Set image path
     *
     * @param string $imagePath
     * @return $this
     */
    public function setImagePath(string $imagePath)
    {
        return $this->setData('image_path', $imagePath);
    }

    /**
     * Get is active
     *
     * @return bool
     */
    public function getIsActive(): bool
    {
        return (bool)$this->getData('is_active');
    }

    /**
     * Set is active
     *
     * @param bool $isActive
     * @return $this
     */
    public function setIsActive(bool $isActive)
    {
        return $this->setData('is_active', $isActive ? 1 : 0);
    }
}
