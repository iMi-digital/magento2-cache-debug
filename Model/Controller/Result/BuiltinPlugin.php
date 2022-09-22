<?php

namespace IMI\CacheDebug\Model\Controller\Result;

use IMI\CacheDebug\Service\Config as DebugConfig;
use Laminas\Http\Header\HeaderInterface as HttpHeaderInterface;
use Magento\Framework\App\PageCache\Kernel;
use Magento\Framework\App\Response\Http as ResponseHttp;
use Magento\Framework\App\State as AppState;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use Magento\PageCache\Model\Config;

class BuiltinPlugin extends \Magento\PageCache\Model\Controller\Result\BuiltinPlugin
{
    public function __construct(
        private readonly Config $config,
        Kernel $kernel,
        private readonly AppState $state,
        private readonly Registry $registry,
        private readonly DebugConfig $debugConfig
    ) {
        parent::__construct($config, $kernel, $state, $registry);
    }

    /**
     * @inheritDoc
     */
    public function afterRenderResult(ResultInterface $subject, ResultInterface $result, ResponseHttp $response)
    {
        $usePlugin = $this->registry->registry('use_page_cache_plugin');

        if (
            !$usePlugin
            || !$this->config->isEnabled()
            || $this->config->getType() !== Config::BUILT_IN
            || $this->state->getMode() == AppState::MODE_DEVELOPER
            || !$this->debugConfig->productionLoggingEnabled()
        ) {
            return parent::afterRenderResult($subject, $result, $response);
        }

        $cacheControlHeader = $response->getHeader('Cache-Control');

        if ($cacheControlHeader instanceof HttpHeaderInterface) {
            $response->setHeader('X-Magento-Cache-Control', $cacheControlHeader->getFieldValue());
        }

        $response->setHeader('X-Magento-Cache-Debug', 'MISS', true);

        return parent::afterRenderResult($subject, $result, $response);
    }
}
