<?php
namespace Jaimin\Blog\Model;

use Jaimin\Blog\Api\Data\PostInterface;
use Jaimin\Blog\Api\PostRepositoryInterface;
use Jaimin\Blog\Model\ResourceModel\Post as PostResource;
use Jaimin\Blog\Model\ResourceModel\Post\CollectionFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class PostRepository implements PostRepositoryInterface
{
    public function __construct(
        private readonly PostFactory     $postFactory,
        private readonly PostResource    $postResource,
        private readonly CollectionFactory $collectionFactory
    ) {}

    public function save(PostInterface $post): PostInterface
    {
        try {
            $this->postResource->save($post);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__('Could not save blog post: %1', $e->getMessage()));
        }
        return $post;
    }

    public function getById(int $postId): PostInterface
    {
        $post = $this->postFactory->create();
        $this->postResource->load($post, $postId);
        if (!$post->getId()) {
            throw new NoSuchEntityException(__('Blog post with ID %1 does not exist.', $postId));
        }
        return $post;
    }

    public function getByUrlKey(string $urlKey): PostInterface
    {
        $post = $this->postFactory->create();
        $this->postResource->load($post, $urlKey, 'url_key');
        if (!$post->getId()) {
            throw new NoSuchEntityException(__('Blog post with URL key "%1" does not exist.', $urlKey));
        }
        return $post;
    }

    public function getList(SearchCriteriaInterface $searchCriteria): array
    {
        $collection = $this->collectionFactory->create();

        foreach ($searchCriteria->getFilterGroups() as $group) {
            foreach ($group->getFilters() as $filter) {
                $collection->addFieldToFilter(
                    $filter->getField(),
                    [$filter->getConditionType() ?: 'eq' => $filter->getValue()]
                );
            }
        }

        if ($searchCriteria->getSortOrders()) {
            foreach ($searchCriteria->getSortOrders() as $sortOrder) {
                $collection->addOrder($sortOrder->getField(), $sortOrder->getDirection());
            }
        }

        $collection->setCurPage($searchCriteria->getCurrentPage() ?? 1);
        $collection->setPageSize($searchCriteria->getPageSize() ?? 20);

        return $collection->getItems();
    }

    public function delete(PostInterface $post): bool
    {
        try {
            $this->postResource->delete($post);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__('Could not delete blog post: %1', $e->getMessage()));
        }
        return true;
    }

    public function deleteById(int $postId): bool
    {
        return $this->delete($this->getById($postId));
    }
}