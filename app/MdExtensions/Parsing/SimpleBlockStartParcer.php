<?php

namespace App\MdExtensions\Parsing;

use League\CommonMark\Parser\Block\AbstractBlockContinueParser;
use League\CommonMark\Parser\Block\BlockStart;
use League\CommonMark\Parser\Block\BlockStartParserInterface;
use League\CommonMark\Parser\Cursor;
use League\CommonMark\Parser\MarkdownParserStateInterface;

final class SimpleBlockStartParcer implements BlockStartParserInterface
{
    public function __construct(
        private AbstractBlockContinueParser $parser,
        private string $blockStartRegex,
    ) {}

    public function tryStart(Cursor $cursor, MarkdownParserStateInterface $parserState): ?BlockStart
    {
        if ($cursor->isIndented()) {
            return BlockStart::none();
        }

        if ($cursor->match($this->blockStartRegex) === null) {
            return BlockStart::none();
        }

        return BlockStart::of($this->parser)->at($cursor);
    }
}
