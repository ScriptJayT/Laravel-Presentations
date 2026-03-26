<?php

namespace App\MdExtensions\Renderers;

use App\MdExtensions\Nodes\SimpleBlock;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;

final class SimpleBlockRenderer implements NodeRendererInterface
{
    public function __construct(
        private string $htmlTag,
        private array $htmlAttributes = []
    ) {}

    public function render(Node $node, ChildNodeRendererInterface $childRenderer): HtmlElement
    {
        SimpleBlock::assertInstanceOf($node);

        $children = $childRenderer->renderNodes($node->children());

        return new HtmlElement(
            tagName: $this->htmlTag,
            attributes: $this->htmlAttributes,
            contents: "\n{$children}\n",
        );
    }
}
