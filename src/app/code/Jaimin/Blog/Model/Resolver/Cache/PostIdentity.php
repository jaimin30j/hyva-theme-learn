<?php
namespace Jaimin\Blog\Model\Resolver\Cache;

use Magento\Framework\GraphQl\Query\Resolver\IdentityInterface;

class PostIdentity implements IdentityInterface
{
    private string $cacheTag = 'jaimin_blog_post';

    public function getIdentities(array $resolvedData): array
    {
        $ids = [];

        // For a list response (blogPosts query)
        if (!empty($resolvedData['items'])) {
            foreach ($resolvedData['items'] as $post) {
                if (!empty($post['post_id'])) {
                    $ids[] = $this->cacheTag . '_' . $post['post_id'];
                }
            }
            $ids[] = $this->cacheTag . '_list'; // Tag the whole list for bulk invalidation
        }

        // For a single post response (blogPost query)
        if (!empty($resolvedData['post_id'])) {
            $ids[] = $this->cacheTag . '_' . $resolvedData['post_id'];
        }

        return $ids;
    }
}