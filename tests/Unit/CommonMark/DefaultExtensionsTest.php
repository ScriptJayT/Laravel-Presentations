<?php

namespace Tests\Unit;

use Illuminate\Support\Str;
use League\CommonMark\Extension\DescriptionList\DescriptionListExtension;
use League\CommonMark\Extension\ExternalLink\ExternalLinkExtension;
use League\CommonMark\Extension\Highlight\HighlightExtension;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DefaultExtensionsTest extends TestCase
{
    private function toMd(string $_content): string
    {
        return Str::of($_content)->markdown(
            [
                'renderer' => [
                    'block_separator' => "\n",
                    'inner_separator' => "\n",
                    'soft_break' => '<br>',
                ],
                'external_link' => [
                    'internal_hosts' => config('app.url'),
                    'open_in_new_window' => true,
                    'html_class' => 'external-link',
                    'nofollow' => 'external',
                    'noopener' => 'external',
                    'noreferrer' => 'external',
                ],
            ],
            [
                new HighlightExtension,
                new ExternalLinkExtension,
                new DescriptionListExtension,
            ]
        )->toString();
    }

    #[Test]
    public function str_facade_works()
    {
        $this->assertEquals(
            "<h1>Title</h1>\n",
            Str::of('# Title')->markdown()->toString(),
        );
    }

    #[Test]
    public function md_trait_convert_to_fn_can_render_titles()
    {
        $this->assertEquals(
            "<h1>Title</h1>\n",
            $this->toMd('# Title'),
        );
    }

    #[Test]
    public function md_trait_convert_to_fn_can_render_highlights()
    {
        $this->assertEquals(
            "<p><mark>Text</mark></p>\n",
            $this->toMd('==Text=='),
        );
    }

    #[Test]
    public function md_trait_convert_to_fn_can_render_descriptionlists()
    {
        $this->assertEquals(
            "<dl>\n<dt>Text</dt>\n<dd>Description</dd>\n<dt>Text</dt>\n<dd>Description</dd>\n</dl>\n",
            $this->toMd("Text\n: Description\n\nText\n: Description"),
        );
    }
}
