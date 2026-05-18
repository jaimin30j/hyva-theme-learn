<?php
namespace Jaimin\Blog\Model\Resolver;

use Jaimin\Blog\Api\PostRepositoryInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class UpdatePost implements ResolverInterface
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
            $post = $this->postRepository->getById((int)$args['id']);
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__($e->getMessage()));
        }

        $input = $args['input'] ?? [];

        // Only set fields that were provided in the input
        if (isset($input['title']))            $post->setTitle($input['title']);
        if (isset($input['content']))          $post->setContent($input['content']);
        if (isset($input['author']))           $post->setAuthor($input['author']);
        if (isset($input['url_key']))          $post->setUrlKey($input['url_key']);
        if (isset($input['status']))           $post->setStatus($input['status']);
        if (isset($input['meta_title']))       $post->setMetaTitle($input['meta_title']);
        if (isset($input['meta_description'])) $post->setMetaDescription($input['meta_description']);

        $saved = $this->postRepository->save($post);

        return [
            'post'    => $saved->getData(),
            'message' => 'Blog post updated successfully.',
        ];
    }
}