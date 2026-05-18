<?php
namespace Jaimin\Blog\Model\Resolver;

use Jaimin\Blog\Api\PostRepositoryInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class DeletePost implements ResolverInterface
{
    public function __construct(
        private readonly PostRepositoryInterface $postRepository
    ) {}

    public function resolve(Field $field, $context, ResolveInfo $info, ?array $value = null, ?array $args = null): array
    {
        if (!$context->getUserId()) {
            throw new GraphQlAuthorizationException(__('Authentication required.'));
        }

        try {
            $this->postRepository->deleteById((int)$args['id']);
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__($e->getMessage()));
        }

        return [
            'success' => true,
            'message' => 'Blog post deleted successfully.',
        ];
    }
}