<?php

declare(strict_types=1);

namespace Inkl\WidgetExtPStrip\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

class Config
{
    public const XML_PATH_ENABLED = 'cms/wysiwyg/widget_replace_p_tags';

    private ScopeConfigInterface $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function isEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_ENABLED);
    }

}