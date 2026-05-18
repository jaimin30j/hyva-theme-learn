<?php
namespace Jaimin\Blog\Model\Resolver;

use Jaimin\Blog\Api\PostRepositoryInterface;
use Jaimin\Blog\Model\PostFactory;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class CreatePost implements ResolverInterface
{
    public function __construct(
        private readonly PostFactory             $postFactory,
        private readonly PostRepositoryInterface $postRepository
    ) {}

    public function resolve(Field $field, $context, ResolveInfo $info, ?array $value = null, ?array $args = null): array
    {
        // Auth check — require logged-in customer or admin
        if (!$context->getUserId()) {
            throw new GraphQlAuthorizationException(__('You must be logged in to create a blog post.'));
        }

        $input = $args['input'] ?? [];

        // Validate required fields
        foreach (['title', 'content', 'url_key'] as $required) {
            if (empty($input[$required])) {
                throw new GraphQlInputException(__('"%1" is required to create a blog post.', $required));
            }
        }

        $post = $this->postFactory->create();
        $post->setTitle($input['title']);
        $post->setContent($input['content']);
        $post->setUrlKey($input['url_key']);
        $post->setAuthor($input['author'] ?? 'Jaimin');
        $post->setStatus($input['status'] ?? 1);

        if (!empty($input['meta_title']))       $post->setMetaTitle($input['meta_title']);
        if (!empty($input['meta_description'])) $post->setMetaDescription($input['meta_description']);

        $saved = $this->postRepository->save($post);

        return [
            'post'    => $saved->getData(),
            'message' => 'Blog post created successfully.',
        ];
    }
}