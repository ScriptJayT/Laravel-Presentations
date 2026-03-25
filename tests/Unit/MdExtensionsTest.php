<?php

namespace Tests\Unit;

use App\Traits\HasMarkdownRenderableContent;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MdExtensionsTest extends TestCase
{
    use HasMarkdownRenderableContent;

    private string $content;

    #[Test]
    public function str_facade_works()
    {
        $res = Str::of('# Title')->markdown()->toString();
        $this->assertEquals($res, "<h1>Title</h1>\n");
    }

    #[Test]
    public function md_trait_convert_to_fn_can_render_titles()
    {
        $res = $this->convertToMd('# Title');
        $this->assertEquals($res, "<h1>Title</h1>\n");
    }

    #[Test]
    public function md_trait_convert_to_fn_can_render_text()
    {
        $res = $this->convertToMd('Text');
        $this->assertEquals($res, "<p>Text</p>\n");
    }

    #[Test]
    public function md_trait_convert_to_fn_can_render_highlights()
    {
        $res = $this->convertToMd('==Text==');
        $this->assertEquals($res, "<p><mark>Text</mark></p>\n");
    }

    #[Test]
    public function md_trait_convert_to_fn_can_render_descriptionlists()
    {
        $res = $this->convertToMd("Text\n: Description\n\nText\n: Description");
        $this->assertEquals($res, "<dl>\n<dt>Text</dt>\n<dd>Description</dd>\n<dt>Text</dt>\n<dd>Description</dd>\n</dl>\n");
    }

    #[Test]
    public function md_trait_convert_to_fn_removes_trailing_escape_slashes()
    {
        $res = $this->convertToMd('Text\\');
        $this->assertEquals($res, "<p>Text</p>\n");
    }

    #[Test]
    public function md_trait_get_rendered_fn_shifts_titles_down_by_one_by_default()
    {
        $this->content = '# Title';
        $res = $this->getRenderedContentAttribute();
        $this->assertEquals($res, "<h2>Title</h2>\n");
    }

    #[Test]
    public function underline_extension_can_be_rendered()
    {
        $this->assertEquals(
            "<p><u>Text</u></p>\n",
            $this->convertToMd('__Text__'),
        );
        $this->assertEquals(
            "<p>Following <u>Text</u> should be <em>underlined</em>.</p>\n",
            $this->convertToMd(
                'Following __Text__ should be *underlined*.'),
        );
        $this->assertEquals(
            "<p><u>Text is <em>underlined</em></u></p>\n",
            $this->convertToMd('__Text is *underlined*__'),
        );
    }

    #[Test]
    public function spoiler_extension_can_be_rendered()
    {
        $this->assertEquals(
            "<p><span data-el=\"spoiler\">Text</span></p>\n",
            $this->convertToMd('||Text||'),
        );
        $this->assertEquals(
            "<p>Following <span data-el=\"spoiler\">Text</span> should be <em>spoiled</em>.</p>\n",
            $this->convertToMd('Following ||Text|| should be *spoiled*.'),
        );
        $this->assertEquals(
            "<p><span data-el=\"spoiler\">Text is <em>spoiled</em></span></p>\n",
            $this->convertToMd('||Text is *spoiled*||'),
        );
    }

    #[Test]
    public function multiple_extensions_can_be_used_together()
    {
        $this->assertEquals(
            "<p><span data-el=\"spoiler\">Spoiler</span> <u>Underline</u></p>\n",
            $this->convertToMd('||Spoiler|| __Underline__'),
        );
    }
}
