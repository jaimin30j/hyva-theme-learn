<?php
namespace Jaimin\Blog\Model\Resolver;

use Jaimin\Blog\Api\PostRepositoryInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class Post implements ResolverInterface
{
    public function __construct(
        private readonly PostRepositoryInterface $postRepository
    ) {}

    public function resolve(Field $field, $context, ResolveInfo $info, ?array $value = null, ?array $args = null): array
    {
        if (empty($args['id']) && empty($args['url_key'])) {
            throw new GraphQlInputException(__('Either "id" or "url_key" must be provided.'));
        }

        try {
            $post = !empty($args['id'])
                ? $this->postRepository->getById((int)$args['id'])
                : $this->postRepository->getByUrlKey($args['url_key']);
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__($e->getMessage()));
        }

        return $post->getData();
    }
}