<?php

namespace App\MdExtensions\Parsing;

use App\MdExtensions\Nodes\SimpleInline;
use League\CommonMark\Parser\Inline\InlineParserInterface;
use League\CommonMark\Parser\Inline\InlineParserMatch;
use League\CommonMark\Parser\InlineParserContext;

final class BracketedInlineParser implements InlineParserInterface
{
    /**
     * @param  string  $nodeClass  the name of the class to use to render the inline element, needs to extend the SimpleInline node
     * @param  string  $shouldEscapeSymbol  if the $symbol needs to be escaped before using it in regex
     */
    public function __construct(
        private string $symbol,
        private string $nodeClass,
        private bool $shouldEscapeSymbol = true,
    ) {}

    public function getMatchDefinition(): InlineParserMatch
    {
        // {symbol}\((.+)\)|{symbol}(\S+)
        // => \((.+)\) matches (words in brackets)
        // or
        // => (\S+) matches non-whitespaces-words
        $startSymbol = $this->shouldEscapeSymbol ? "\\{$this->symbol}" : $this->symbol;

        return InlineParserMatch::regex("{$startSymbol}\((.+)\)|{$startSymbol}(\S+)");
    }

    public function parse(InlineParserContext $inlineContext): bool
    {
        $cursor = $inlineContext->getCursor();
        // Check if this match does starts with the startsymbol
        if ($cursor->peek(0) !== $this->symbol) {
            return false;
        }

        $guessStartBracket = $cursor->peek(1);
        $guessEndBracket = $cursor->peek($inlineContext->getFullMatchLength() - 1);
        $isBracketed = $guessStartBracket === '(' && $guessEndBracket === ')';

        $matches = $inlineContext->getSubMatches();
        // if the match is not bracketed; the content is in the second capture group due to the order of the regex
        $content = $isBracketed ? $matches[0] : $matches[1];

        $cursor->advanceBy($inlineContext->getFullMatchLength());

        $subscript = new $this->nodeClass($content);
        if (! $subscript instanceof SimpleInline) {
            return false;
        }

        $inlineContext->getContainer()->appendChild($subscript);

        return true;
    }
}
