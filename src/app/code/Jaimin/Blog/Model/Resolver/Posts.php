<?php
namespace Jaimin\Blog\Model\Resolver;

use Jaimin\Blog\Model\ResourceModel\Post\CollectionFactory;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class Posts implements ResolverInterface
{
    public function __construct(
        private readonly CollectionFactory $collectionFactory
    ) {}

    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        ?array $value = null,
        ?array $args = null
    ): array {
        $pageSize    = (int)($args['pageSize']    ?? 20);
        $currentPage = (int)($args['currentPage'] ?? 1);

        if ($pageSize < 1 || $pageSize > 100) {
            throw new GraphQlInputException(__('pageSize must be between 1 and 100.'));
        }
        if ($currentPage < 1) {
            throw new GraphQlInputException(__('currentPage must be 1 or greater.'));
        }

        // ── Step 1: build collection with filters + sorting only ────────────
        // Do NOT apply pagination yet — getSize() must run against the full
        // filtered result set, not the current page slice.
        $collection = $this->collectionFactory->create();

        // Apply filters
        $this->applyFilters($collection, $args['filter'] ?? []);

        // Apply sorting
        $this->applySorting($collection, $args['sort'] ?? []);

        // ── Step 2: get total count BEFORE pagination ────────────────────────
        // getSize() fires: SELECT COUNT(*) with all WHERE clauses applied.
        // This is the correct total_count the client needs for page controls.
        $totalCount = $collection->getSize();

        // ── Step 3: NOW apply pagination ─────────────────────────────────────
        $collection->setCurPage($currentPage);
        $collection->setPageSize($pageSize);

        // ── Step 4: load the page slice ──────────────────────────────────────
        $items = [];
        foreach ($collection->getItems() as $post) {
            $items[] = $post->getData();
        }

        $totalPages = $pageSize > 0 ? (int)ceil($totalCount / $pageSize) : 1;

        return [
            'items'       => $items,
            'total_count' => $totalCount,
            'page_info'   => [
                'page_size'    => $pageSize,
                'current_page' => $currentPage,
                'total_pages'  => $totalPages,
            ],
        ];
    }

    // ── Filter mapper ─────────────────────────────────────────────────────────
    // Maps GraphQL BlogPostFilterInput fields → Magento collection conditions.
    // Each GraphQL input type maps to a specific Magento condition type.

    private function applyFilters(
        \Jaimin\Blog\Model\ResourceModel\Post\Collection $collection,
        array $filters
    ): void {
        if (empty($filters)) {
            return;
        }

        foreach ($filters as $field => $conditionInput) {
            match ($field) {

                // FilterEqualTypeInput → { eq: "1" } or { in: ["1","0"] }
                'status' => $this->applyEqualFilter($collection, 'status', $conditionInput),

                // FilterMatchTypeInput → { match: "GraphQL" }
                // Uses LIKE %value% for partial matching
                'title'  => $this->applyMatchFilter($collection, 'title', $conditionInput),
                'author' => $this->applyMatchFilter($collection, 'author', $conditionInput),

                // FilterRangeTypeInput → { from: "2024-01-01", to: "2024-12-31" }
                // Maps to BETWEEN / >= / <=
                'created_at' => $this->applyRangeFilter($collection, 'created_at', $conditionInput),
                'updated_at' => $this->applyRangeFilter($collection, 'updated_at', $conditionInput),

                // Silently ignore unknown fields rather than throwing
                // to maintain forward-compatibility
                default => null,
            };
        }
    }

    private function applyEqualFilter(
        \Jaimin\Blog\Model\ResourceModel\Post\Collection $collection,
        string $field,
        array $condition
    ): void {
        // { eq: "1" }  → ['eq' => '1']
        // { in: ["0","1"] } → ['in' => ['0','1']]
        if (isset($condition['eq'])) {
            $collection->addFieldToFilter($field, ['eq' => $condition['eq']]);
        } elseif (isset($condition['in'])) {
            $collection->addFieldToFilter($field, ['in' => $condition['in']]);
        } elseif (isset($condition['neq'])) {
            $collection->addFieldToFilter($field, ['neq' => $condition['neq']]);
        }
    }

    private function applyMatchFilter(
        \Jaimin\Blog\Model\ResourceModel\Post\Collection $collection,
        string $field,
        array $condition
    ): void {
        // { match: "GraphQL" } → LIKE '%GraphQL%'
        if (isset($condition['match'])) {
            $collection->addFieldToFilter($field, ['like' => '%' . $condition['match'] . '%']);
        }
    }

    private function applyRangeFilter(
        \Jaimin\Blog\Model\ResourceModel\Post\Collection $collection,
        string $field,
        array $condition
    ): void {
        // { from: "2024-01-01 00:00:00", to: "2024-12-31 23:59:59" }
        // Both from and to are optional — either alone is valid.
        if (isset($condition['from']) && isset($condition['to'])) {
            $collection->addFieldToFilter($field, [
                'from' => $condition['from'],
                'to'   => $condition['to'],
                'date' => true,  // tells Magento these are date strings
            ]);
        } elseif (isset($condition['from'])) {
            $collection->addFieldToFilter($field, ['gteq' => $condition['from']]);
        } elseif (isset($condition['to'])) {
            $collection->addFieldToFilter($field, ['lteq' => $condition['to']]);
        }
    }

    private function applySorting(
        \Jaimin\Blog\Model\ResourceModel\Post\Collection $collection,
        array $sort
    ): void {
        if (empty($sort)) {
            // Default: newest first
            $collection->addOrder('created_at', 'DESC');
            return;
        }

        $allowedFields = ['created_at', 'updated_at', 'title', 'author'];

        foreach ($sort as $field => $direction) {
            if (in_array($field, $allowedFields, true)) {
                $collection->addOrder(
                    $field,
                    strtoupper($direction) === 'ASC' ? 'ASC' : 'DESC'
                );
            }
        }
    }
}