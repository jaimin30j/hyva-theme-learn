<?php
namespace Jaimin\Blog\Model;

use Jaimin\Blog\Api\Data\PostInterface;
use Magento\Framework\Model\AbstractModel;

class Post extends AbstractModel implements PostInterface
{
    protected $_eventPrefix = 'jaimin_blog_post';

    protected function _construct(): void
    {
        $this->_init(\Jaimin\Blog\Model\ResourceModel\Post::class);
    }

    public function getPostId(): ?int        { return $this->getData(self::POST_ID) ? (int)$this->getData(self::POST_ID) : null; }
    public function getTitle(): string       { return (string)$this->getData(self::TITLE); }
    public function getContent(): string     { return (string)$this->getData(self::CONTENT); }
    public function getAuthor(): string      { return (string)$this->getData(self::AUTHOR); }
    public function getStatus(): int         { return (int)$this->getData(self::STATUS); }
    public function getUrlKey(): string      { return (string)$this->getData(self::URL_KEY); }
    public function getMetaTitle(): ?string  { return $this->getData(self::META_TITLE); }
    public function getMetaDescription(): ?string { return $this->getData(self::META_DESCRIPTION); }
    public function getCreatedAt(): ?string  { return $this->getData(self::CREATED_AT); }
    public function getUpdatedAt(): ?string  { return $this->getData(self::UPDATED_AT); }

    public function setPostId(int $id): self          { return $this->setData(self::POST_ID, $id); }
    public function setTitle(string $v): self         { return $this->setData(self::TITLE, $v); }
    public function setContent(string $v): self       { return $this->setData(self::CONTENT, $v); }
    public function setAuthor(string $v): self        { return $this->setData(self::AUTHOR, $v); }
    public function setStatus(int $v): self           { return $this->setData(self::STATUS, $v); }
    public function setUrlKey(string $v): self        { return $this->setData(self::URL_KEY, $v); }
    public function setMetaTitle(?string $v): self    { return $this->setData(self::META_TITLE, $v); }
    public function setMetaDescription(?string $v): self { return $this->setData(self::META_DESCRIPTION, $v); }
}