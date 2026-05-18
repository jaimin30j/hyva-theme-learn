<?php
namespace Jaimin\Blog\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context): void
    {
        $setup->startSetup();

        $table = $setup->getConnection()->newTable(
            $setup->getTable('jaimin_blog_post')
        )
        ->addColumn('post_id', Table::TYPE_INTEGER, null, [
            'identity' => true,
            'nullable' => false,
            'primary'  => true,
            'unsigned' => true,
        ], 'Post ID')
        ->addColumn('title', Table::TYPE_TEXT, 255, [
            'nullable' => false,
        ], 'Post Title')
        ->addColumn('content', Table::TYPE_TEXT, '64k', [
            'nullable' => false,
        ], 'Post Content')
        ->addColumn('author', Table::TYPE_TEXT, 100, [
            'nullable' => false,
            'default'  => 'Jaimin',
        ], 'Author Name')
        ->addColumn('status', Table::TYPE_SMALLINT, null, [
            'nullable' => false,
            'default'  => 1,
        ], 'Status: 1=enabled, 0=disabled')
        ->addColumn('url_key', Table::TYPE_TEXT, 100, [
            'nullable' => false,
        ], 'URL Key (slug)')
        ->addColumn('meta_title', Table::TYPE_TEXT, 255, [
            'nullable' => true,
        ], 'Meta Title')
        ->addColumn('meta_description', Table::TYPE_TEXT, 500, [
            'nullable' => true,
        ], 'Meta Description')
        ->addColumn('created_at', Table::TYPE_TIMESTAMP, null, [
            'nullable' => false,
            'default'  => Table::TIMESTAMP_INIT,
        ], 'Created At')
        ->addColumn('updated_at', Table::TYPE_TIMESTAMP, null, [
            'nullable' => false,
            'default'  => Table::TIMESTAMP_INIT_UPDATE,
        ], 'Updated At')
        ->addIndex($setup->getIdxName('jaimin_blog_post', ['url_key']), ['url_key'])
        ->addIndex($setup->getIdxName('jaimin_blog_post', ['status']), ['status'])
        ->setComment('Jaimin Blog Posts Table');

        $setup->getConnection()->createTable($table);
        $setup->endSetup();
    }
}