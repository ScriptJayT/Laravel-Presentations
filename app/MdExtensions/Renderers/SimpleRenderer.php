<?php

namespace App\MdExtensions\Renderers;

use App\MdExtensions\Parsing\SimpleDelimiter;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;
use League\CommonMark\Xml\XmlNodeRendererInterface;
use Stringable;

class SimpleRenderer implements NodeRendererInterface, XmlNodeRendererInterface
{
    public function __construct(
        private string $htmlTag,
        private array $htmlAttributes = []
    ) {}

    public function render(Node $node, ChildNodeRendererInterface $childRenderer): Stringable
    {
        SimpleDelimiter::assertInstanceOf($node);
        $attrs = array_merge(
            $this->htmlAttributes,
            $node->data->get('attributes'),
        );

        return new HtmlElement(
            tagName: $this->htmlTag,
            attributes: $attrs,
            contents: $childRenderer->renderNodes($node->children())
        );
    }

    public function getTag(): string
    {
        return $this->htmlTag;
    }

    public function getXmlTagName(Node $node): string
    {
        return $this->getTag();
    }

    /**
     * {@inheritDoc}
     */
    public function getXmlAttributes(Node $node): array
    {
        return [];
    }
}
