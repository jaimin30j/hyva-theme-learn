<?php

declare(strict_types=1);

namespace Jaimin\PreviouslyPurchased\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Config extends AbstractHelper
{
    private const XML_ENABLED =
        'jaimin_previously_purchased/general/enabled';

    private const XML_MAX_PRODUCTS =
        'jaimin_previously_purchased/general/max_products';

    private const XML_LABEL_TEXT =
        'jaimin_previously_purchased/general/label_text';

    public function isEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getMaxProducts(): int
    {
        return (int)$this->scopeConfig->getValue(
            self::XML_MAX_PRODUCTS,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getLabelText(): string
    {
        return (string)$this->scopeConfig->getValue(
            self::XML_LABEL_TEXT,
            ScopeInterface::SCOPE_STORE
        );
    }
}