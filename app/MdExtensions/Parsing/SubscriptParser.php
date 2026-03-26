<?php

namespace App\MdExtensions\Parsing;

use App\MdExtensions\Nodes\Subscript;
use League\CommonMark\Parser\Inline\InlineParserInterface;
use League\CommonMark\Parser\Inline\InlineParserMatch;
use League\CommonMark\Parser\InlineParserContext;

final class SubscriptParser implements InlineParserInterface
{
    public function getMatchDefinition(): InlineParserMatch
    {
        // \^\(([^)]+)\)
        // \^\(([^()]+)\)
        return InlineParserMatch::regex('\^\(([^()]+)\)');
    }

    public function parse(InlineParserContext $inlineContext): bool
    {
        $cursor = $inlineContext->getCursor();

        // Check if this starts with ^(
        if ($cursor->peek(-2) !== '^') {
            return false;
        }

        // Advance past the ^(
        $cursor->advanceBy(2);

        // Get the captured content
        [$content] = $inlineContext->getSubMatches();

        // Create and add the subscript node
        $subscript = new Subscript($content);
        $inlineContext->getContainer()->appendChild($subscript);

        return true;
    }
}
