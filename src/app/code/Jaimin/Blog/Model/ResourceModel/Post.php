<?php
namespace Jaimin\Blog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Post extends AbstractDb
{
    protected function _construct(): void
    {
        // table name, primary key column
        $this->_init('jaimin_blog_post', 'post_id');
    }
}