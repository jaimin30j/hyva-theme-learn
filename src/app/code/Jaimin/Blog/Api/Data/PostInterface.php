<?php
namespace Jaimin\Blog\Api\Data;

interface PostInterface
{
    const POST_ID          = 'post_id';
    const TITLE            = 'title';
    const CONTENT          = 'content';
    const AUTHOR           = 'author';
    const STATUS           = 'status';
    const URL_KEY          = 'url_key';
    const META_TITLE       = 'meta_title';
    const META_DESCRIPTION = 'meta_description';
    const CREATED_AT       = 'created_at';
    const UPDATED_AT       = 'updated_at';

    public function getPostId(): ?int;
    public function getTitle(): string;
    public function getContent(): string;
    public function getAuthor(): string;
    public function getStatus(): int;
    public function getUrlKey(): string;
    public function getMetaTitle(): ?string;
    public function getMetaDescription(): ?string;
    public function getCreatedAt(): ?string;
    public function getUpdatedAt(): ?string;

    public function setPostId(int $postId): self;
    public function setTitle(string $title): self;
    public function setContent(string $content): self;
    public function setAuthor(string $author): self;
    public function setStatus(int $status): self;
    public function setUrlKey(string $urlKey): self;
    public function setMetaTitle(?string $metaTitle): self;
    public function setMetaDescription(?string $metaDescription): self;
}