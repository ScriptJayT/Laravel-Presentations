<?php

namespace App\MdExtensions\Renderers;

use App\MdExtensions\Nodes\SimpleInline;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;

final class SimpleInlineRenderer implements NodeRendererInterface
{
    public function __construct(
        private string $htmlTag,
        private array $htmlAttributes = []
    ) {}

    public function render(Node $node, ChildNodeRendererInterface $childRenderer): HtmlElement
    {
        SimpleInline::assertInstanceOf($node);

        /** @var SimpleInline */
        $content = $node->getContent();

        return new HtmlElement(
            tagName: $this->htmlTag,
            attributes: $this->htmlAttributes,
            contents: $content,
        );
    }
}
