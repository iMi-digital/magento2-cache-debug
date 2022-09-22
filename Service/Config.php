<?php

namespace IMI\CacheDebug\Service;

use Magento\Framework\App\Config\ScopeConfigInterface;

class Config
{
    private const CONFIG_PRODUCTION_LOGGING_ENABLED = 'system/full_page_cache/production_logging_enabled';

    public function __construct(private readonly ScopeConfigInterface $scopeConfig)
    {
    }

    public function productionLoggingEnabled(): bool
    {
        return boolval($this->scopeConfig->getValue(self::CONFIG_PRODUCTION_LOGGING_ENABLED));
    }
}
