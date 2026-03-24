<?php

namespace Tests\Unit;

use App\MdExtensions\Extensions\ExtensionFactory;
use App\MdExtensions\Extensions\SpoilerExtension;
use App\MdExtensions\Extensions\UnderlineExtension;
use App\MdExtensions\Parsing\SimpleDelimiter;
use App\MdExtensions\Processors\SimpleDelimiterProcessor;
use App\MdExtensions\Renderers\SimpleRenderer;
use App\Traits\HasMarkdownRenderableContent;
use Illuminate\Support\Str;
use League\CommonMark\Delimiter\Processor\DelimiterProcessorInterface;
use League\CommonMark\Node\Inline\DelimitedInterface;
use League\CommonMark\Xml\XmlNodeRendererInterface;
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
    public function extension_factory_can_be_called()
    {
        $extension = new ExtensionFactory('~', 2, 'del');
        $this->assertInstanceOf(XmlNodeRendererInterface::class, $extension->getRenderer());
        $this->assertInstanceOf(SimpleRenderer::class, $extension->getRenderer());
        $this->assertEquals(
            $extension->getRenderer()->getTag(),
            'del',
        );
        $this->assertInstanceOf(DelimiterProcessorInterface::class, $extension->getDelimiterProcessor());
        $this->assertInstanceOf(SimpleDelimiterProcessor::class, $extension->getDelimiterProcessor());
        $this->assertEquals(
            $extension->getDelimiterProcessor()->getOpeningCharacter(),
            '~'
        );
        $this->assertEquals(
            $extension->getDelimiterProcessor()->getClosingCharacter(),
            '~'
        );
        $this->assertEquals(
            $extension->getDelimiterProcessor()->getMinLength(),
            2
        );
        $this->assertInstanceOf(DelimitedInterface::class, $extension->getDelimiter());
        $this->assertInstanceOf(SimpleDelimiter::class, $extension->getDelimiter());
        $this->assertEquals(
            $extension->getDelimiter()->getOpeningDelimiter(),
            '~'
        );
        $this->assertEquals(
            $extension->getDelimiter()->getClosingDelimiter(),
            '~'
        );
    }

    #[Test]
    public function underline_extension_can_be_rendered()
    {
        $this->assertEquals(
            $this->convertToMd(
                '__Text__',
                _extensions: [new UnderlineExtension],
            ),
            "<p><u>Text</u></p>\n"
        );
        $this->assertEquals(
            $this->convertToMd(
                'Following __Text__ should be *underlined*.',
                _extensions: [new UnderlineExtension],
            ),
            "<p>Following <u>Text</u> should be <em>underlined</em>.</p>\n"
        );
        $this->assertEquals(
            $this->convertToMd(
                '__Text is *underlined*__',
                _extensions: [new UnderlineExtension],
            ),
            "<p><u>Text is <em>underlined</em></u></p>\n"
        );
    }

    #[Test]
    public function spoiler_extension_can_be_rendered()
    {
        $this->assertEquals(
            $this->convertToMd(
                '||Text||',
                _extensions: [new SpoilerExtension],
            ),
            "<p><span data-el=\"spoiler\">Text</span></p>\n"
        );
        $this->assertEquals(
            $this->convertToMd(
                'Following ||Text|| should be *spoiled*.',
                _extensions: [new SpoilerExtension],
            ),
            "<p>Following <span data-el=\"spoiler\">Text</span> should be <em>spoiled</em>.</p>\n"
        );
        $this->assertEquals(
            $this->convertToMd(
                '||Text is *spoiled*||',
                _extensions: [new SpoilerExtension],
            ),
            "<p><span data-el=\"spoiler\">Text is <em>spoiled</em></span></p>\n"
        );
    }
}
