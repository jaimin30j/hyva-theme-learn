<?php
namespace Jaimin\Blog\Model\ResourceModel\Post;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'post_id';

    protected function _construct(): void
    {
        $this->_init(
            \Jaimin\Blog\Model\Post::class,
            \Jaimin\Blog\Model\ResourceModel\Post::class
        );
    }
}