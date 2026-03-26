<?php

namespace Tests\Unit;

use App\MdExtensions\Extensions\SmallBlockExtension;
use App\MdExtensions\Extensions\SpoilerExtension;
use App\MdExtensions\Extensions\UnderlineExtension;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CustomExtensionsTest extends TestCase
{
    private function toMd(string $_content): string
    {
        return Str::of($_content)->markdown(
            extensions: [
                new UnderlineExtension,
                new SpoilerExtension,
                new SmallBlockExtension,
            ]
        )->toString();
    }

    #[Test]
    public function underline_extension_can_be_rendered()
    {
        $this->assertEquals(
            "<p><u>Text</u></p>\n",
            $this->toMd('__Text__'),
        );
        $this->assertEquals(
            "<p>Following <u>Text</u> should be <em>underlined</em>.</p>\n",
            $this->toMd('Following __Text__ should be *underlined*.'),
        );
        $this->assertEquals(
            "<p><u>Text is <em>underlined</em></u></p>\n",
            $this->toMd('__Text is *underlined*__'),
        );
    }

    #[Test]
    public function spoiler_extension_can_be_rendered()
    {
        $this->assertEquals(
            "<p><span data-el=\"spoiler\">Text</span></p>\n",
            $this->toMd('||Text||'),
        );
        $this->assertEquals(
            "<p>Following <span data-el=\"spoiler\">Text</span> should be <em>spoiled</em>.</p>\n",
            $this->toMd('Following ||Text|| should be *spoiled*.'),
        );
        $this->assertEquals(
            "<p><span data-el=\"spoiler\">Text is <em>spoiled</em></span></p>\n",
            $this->toMd('||Text is *spoiled*||'),
        );
    }

    #[Test]
    public function smallblock_extension_can_be_rendered()
    {
        $this->assertEquals(
            "<div data-el=\"small\">Text</div>\n",
            $this->toMd('-# Text'),
        );
    }

    #[Test]
    public function multiple_delimiter_extensions_can_be_used_together()
    {
        $this->assertEquals(
            "<p><span data-el=\"spoiler\">Spoiler</span> <u>Underline</u></p>\n",
            $this->toMd('||Spoiler|| __Underline__'),
        );
    }
}
