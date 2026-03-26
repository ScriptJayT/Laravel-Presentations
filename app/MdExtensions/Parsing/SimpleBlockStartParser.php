<?php

namespace App\MdExtensions\Parsing;

use League\CommonMark\Parser\Block\BlockStart;
use League\CommonMark\Parser\Block\BlockStartParserInterface;
use League\CommonMark\Parser\Cursor;
use League\CommonMark\Parser\MarkdownParserStateInterface;

class SimpleBlockStartParser implements BlockStartParserInterface
{
    public function __construct(
        private string $blockStartRegex,
    ) {}

    public function tryStart(
        Cursor $cursor,
        MarkdownParserStateInterface $parserState
    ): ?BlockStart {
        if ($cursor->match($this->blockStartRegex) === null) {
            return BlockStart::none();
        }

        return BlockStart::none();
    }
}
