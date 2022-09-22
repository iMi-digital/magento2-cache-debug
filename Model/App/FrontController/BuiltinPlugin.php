<?php

namespace IMI\CacheDebug\Model\App\FrontController;

use IMI\CacheDebug\Service\Config as DebugConfig;
use Magento\Framework\App\PageCache\Kernel;
use Magento\Framework\App\PageCache\Version;
use Magento\Framework\App\Response\Http as ResponseHttp;
use Magento\Framework\App\State;
use Magento\PageCache\Model\App\FrontController\BuiltinPlugin as BaseBuiltinPlugin;
use Magento\PageCache\Model\Config;

class BuiltinPlugin extends BaseBuiltinPlugin
{
    public function __construct(
        Config $config,
        Version $version,
        Kernel $kernel,
        State $state,
        private readonly DebugConfig $debugConfig
    ) {
        parent::__construct($config, $version, $kernel, $state);
    }

    /**
     * @inheritDoc
     */
    protected function addDebugHeader(ResponseHttp $response, $name, $value, $replace = false)
    {
        if (
            $this->state->getMode() != State::MODE_DEVELOPER
            && $this->debugConfig->productionLoggingEnabled()
        ) {
            $response->setHeader($name, $value, $replace);
        } else {
            parent::addDebugHeader($response, $name, $value, $replace);
        }
    }
}
