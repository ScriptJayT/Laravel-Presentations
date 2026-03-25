<?php

namespace Tests\Unit;

use App\MdExtensions\Extensions\UnderlineExtension;
use App\Traits\HasMarkdownRenderableContent;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class RenderableContentTraitTest extends TestCase
{
    use HasMarkdownRenderableContent;

    private string $content;

    #[Test]
    public function convert_to_fn_can_render()
    {
        $this->assertEquals(
            "<p>Text</p>\n",
            $this->convertToMd('Text'),
        );
    }

    #[Test]
    public function convert_to_fn_adding_same_extension_twice_gets_resolved()
    {
        $this->assertEquals(
            "<p>Text</p>\n",
            $this->convertToMd('Text', [
                new UnderlineExtension,
                new UnderlineExtension,
            ]),
        );
    }

    #[Test]
    public function convert_to_fn_removes_trailing_escape_slashes()
    {
        $this->assertEquals(
            "<p>Text</p>\n",
            $this->convertToMd('Text\\'),
        );
    }

    #[Test]
    public function get_rendered_content_fn_shifts_titles_down_by_one_by_default()
    {
        $this->content = '# Title';
        $this->assertEquals(
            "<h2>Title</h2>\n",
            $this->getRenderedContentAttribute(),
        );
    }
}
