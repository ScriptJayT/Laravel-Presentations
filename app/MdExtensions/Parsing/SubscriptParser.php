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
        // \^\((.+)\)|\^(\S+)
        // => \^\((.+)\) matches ^(words in brackets)
        // or
        // => \^(\S+) matches ^non-whitespaces-words
        $startSymbol = "\^";

        return InlineParserMatch::regex("{$startSymbol}\((.+)\)|{$startSymbol}(\S+)");
    }

    public function parse(InlineParserContext $inlineContext): bool
    {
        $cursor = $inlineContext->getCursor();

        // Check if this match does starts with ^
        if ($cursor->peek(0) !== '^') {
            return false;
        }

        $guessStartBracket = $cursor->peek(1);
        $guessEndBracket = $cursor->peek($inlineContext->getFullMatchLength() - 1);
        $isBracketed = $guessStartBracket === '(' && $guessEndBracket === ')';

        $matches = $inlineContext->getSubMatches();
        // if the match is not bracketed; the content is in the second capture group due to the order of the regex
        $content = $isBracketed ? $matches[0] : $matches[1];

        $cursor->advanceBy($inlineContext->getFullMatchLength());

        $subscript = new Subscript($content);
        $inlineContext->getContainer()->appendChild($subscript);

        return true;
    }
}
