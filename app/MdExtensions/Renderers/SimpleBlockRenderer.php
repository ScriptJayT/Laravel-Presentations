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

        return new HtmlElement(
            $this->htmlTag,
            $this->htmlAttributes,
            $node->getContent(),
        );
    }
}
