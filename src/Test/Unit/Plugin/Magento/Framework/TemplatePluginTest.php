<?php

declare(strict_types=1);

namespace Inkl\WidgetExtPStrip\Test\Unit\Plugin\Magento\Framework;

use Inkl\WidgetExtPStrip\Model\Config;
use Inkl\WidgetExtPStrip\Plugin\Magento\Framework\Filter\TemplatePlugin;
use PHPUnit\Framework\TestCase;

class TemplatePluginTest extends TestCase
{
    private Config $config;
    private TemplatePlugin $templatePlugin;

    protected function setUp(): void
    {
        $this->config = $this->createMock(Config::class);
        $this->templatePlugin = new TemplatePlugin($this->config);
    }

    public function testReplacePTagsIsDisabled()
    {
        $this->config->method('isEnabled')->willReturn(false);

        $value = '<p></p>';
        $expected = '<p></p>';

        $actual = $this->templatePlugin->replacePTags($value);

        $this->assertSame($expected, $actual);
    }

    /**
     * @dataProvider dataProviderTestReplacePTags
     */
    public function testReplacePTags(string $value, string $expected)
    {
        $this->config->method('isEnabled')->willReturn(true);

        $actual = $this->templatePlugin->replacePTags($value);

        $this->assertSame($expected, $actual);
    }

    public function dataProviderTestReplacePTags(): array
    {
        return [
            [
                '<p></p>',
                ''
            ],
            [
                '<p>&nbsp;</p>',
                ''
            ],
            [
                '{{widget name="test"}}',
                '{{widget name="test"}}'
            ],
            [
                '<p>{{widget name="test"}}</p>',
                '{{widget name="test"}}'
            ],
            [
                '<p>{{widget name="test"}}</p><p>{{template}}</p>',
                '{{widget name="test"}}<p>{{template}}</p>'
            ],
            [
                '<p>test</p><p>{{widget name="test"}}</p><p>test</p>',
                '<p>test</p>{{widget name="test"}}<p>test</p>'
            ],
            [
                '<p>test</p><p>{{widget name="test"}}</p><p>test</p><p>{{widget name="test"}}</p>',
                '<p>test</p>{{widget name="test"}}<p>test</p>{{widget name="test"}}'
            ]
        ];
    }
}
