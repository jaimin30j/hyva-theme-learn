<?php
namespace Jaimin\Blog\Api;

use Jaimin\Blog\Api\Data\PostInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface PostRepositoryInterface
{
    public function save(PostInterface $post): PostInterface;
    public function getById(int $postId): PostInterface;
    public function getByUrlKey(string $urlKey): PostInterface;
    public function getList(SearchCriteriaInterface $searchCriteria): array;
    public function delete(PostInterface $post): bool;
    public function deleteById(int $postId): bool;
}