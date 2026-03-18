<?php

namespace App\Traits;

use App\MdExtensions\Extensions\UnderlineExtension;
use Illuminate\Support\Str;
use League\CommonMark\Extension\DescriptionList\DescriptionListExtension;
use League\CommonMark\Extension\ExternalLink\ExternalLinkExtension;
use League\CommonMark\Extension\Highlight\HighlightExtension;
use TuchSoft\CommonMarkHeadingShifter\HeadingShifterExtension;

trait HasMarkdownRenderableContent
{
    // overridable defaults:
    protected function getMdSettings(): array
    {
        return ['heading_shifter' => ['shift_by' => 1]];
    }

    protected function getMdExtensions(): array
    {
        return [];
    }

    protected function getRenderedContentAttribute(): string
    {
        return Str::of($this->content)->markdown(
            [
                'html_input' => 'strip',
                'allow_unsafe_links' => false,
                'max_nesting_level' => 10,
                'renderer' => [
                    'block_separator' => "\n",
                    'inner_separator' => "\n",
                    'soft_break' => '<br>',
                ],
                'commonmark' => [
                    'enable_em' => true,
                    'enable_strong' => true,
                    'use_asterisk' => true,
                    'use_underscore' => false,
                    'unordered_list_markers' => ['-', '*', '+'],
                ],
                'external_link' => [
                    'internal_hosts' => config('app.url'),
                    'open_in_new_window' => true,
                    'html_class' => 'external-link',
                    'nofollow' => 'external',
                    'noopener' => 'external',
                    'noreferrer' => 'external',
                ],
                ...$this->getMdSettings(),
            ],
            [
                new HeadingShifterExtension,
                new HighlightExtension,
                new ExternalLinkExtension,
                new DescriptionListExtension,
                new UnderlineExtension,

                ...$this->getMdExtensions(),
            ]
        )->replace('\\', '');
    }
}
