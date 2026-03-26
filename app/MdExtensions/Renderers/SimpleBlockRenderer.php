<?php

declare(strict_types=1);

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\MdExtensions\Renderers;

use League\CommonMark\Node\Block\AbstractBlock;
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
        AbstractBlock::assertInstanceOf($node);

        $separator = $childRenderer->getBlockSeparator();

        return new HtmlElement(
            $this->htmlTag,
            $this->htmlAttributes,
            $separator.$childRenderer->renderNodes($node->children()).$separator
        );
    }
}
