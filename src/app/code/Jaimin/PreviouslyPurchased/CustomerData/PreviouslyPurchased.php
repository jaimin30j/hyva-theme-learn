<?php

declare(strict_types=1);

namespace Jaimin\PreviouslyPurchased\CustomerData;

use Jaimin\PreviouslyPurchased\Helper\Config;
use Magento\Customer\CustomerData\SectionSourceInterface;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\App\ResourceConnection;
use Magento\Sales\Model\Order\Config as OrderConfig;

class PreviouslyPurchased implements SectionSourceInterface
{
    private CustomerSession $customerSession;

    private ResourceConnection $resourceConnection;

    private OrderConfig $orderConfig;

    private Config $config;

    public function __construct(
        CustomerSession $customerSession,
        ResourceConnection $resourceConnection,
        OrderConfig $orderConfig,
        Config $config
    ) {
        $this->customerSession = $customerSession;
        $this->resourceConnection = $resourceConnection;
        $this->orderConfig = $orderConfig;
        $this->config = $config;
    }

    public function getSectionData(): array
    {
        if (!$this->config->isEnabled()) {
            return [];
        }

        $customerId = (int)$this->customerSession->getCustomerId();

        if (!$customerId) {
            return [];
        }

        $connection = $this->resourceConnection->getConnection();

        $salesOrderTable =
            $this->resourceConnection->getTableName('sales_order');

        $salesOrderItemTable =
            $this->resourceConnection->getTableName('sales_order_item');

        $select = $connection->select()
            ->distinct()
            ->from(
                ['soi' => $salesOrderItemTable],
                ['sku']
            )
            ->joinInner(
                ['so' => $salesOrderTable],
                'so.entity_id = soi.order_id',
                []
            )
            ->where('so.customer_id = ?', $customerId)
            ->where(
                'so.status IN (?)',
                $this->orderConfig->getVisibleOnFrontStatuses()
            )
            ->where('soi.parent_item_id IS NULL')
            ->order('so.created_at DESC')
            ->limit($this->config->getMaxProducts());

        $skus = $connection->fetchCol($select);

        return [
            'enabled' => true,
            'skus' => array_values(array_unique($skus)),
            'label_text' => $this->config->getLabelText()
        ];
    }
}