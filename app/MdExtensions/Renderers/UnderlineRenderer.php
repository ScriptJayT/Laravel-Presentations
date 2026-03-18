<?php

namespace App\MdExtensions\Renderers;

use App\MdExtensions\Parsing\UnderlineDelimiter as Delimiter;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;
use League\CommonMark\Xml\XmlNodeRendererInterface;
use Stringable;

final class UnderlineRenderer implements NodeRendererInterface, XmlNodeRendererInterface
{
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): Stringable
    {
        Delimiter::assertInstanceOf($node);

        return new HtmlElement(
            'u',
            $node->data->get('attributes'),
            $childRenderer->renderNodes($node->children())
        );
    }

    public function getXmlTagName(Node $node): string
    {
        return 'u';
    }

    /**
     * {@inheritDoc}
     */
    public function getXmlAttributes(Node $node): array
    {
        return [];
    }
}
