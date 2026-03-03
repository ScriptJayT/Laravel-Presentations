<?php

namespace App\Traits;

use Illuminate\Support\Str;
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
                ...$this->getMdSettings(),
            ],
            [
                new HeadingShifterExtension,
                ...$this->getMdExtensions(),
            ]
        );
    }
}
