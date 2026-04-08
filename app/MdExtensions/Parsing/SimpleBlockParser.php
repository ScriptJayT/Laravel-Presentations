<?php

namespace App\MdExtensions\Parsing;

use App\MdExtensions\Nodes\SimpleBlock;
use League\CommonMark\Node\Block\AbstractBlock;
use League\CommonMark\Parser\Block\AbstractBlockContinueParser;
use League\CommonMark\Parser\Block\BlockContinue;
use League\CommonMark\Parser\Block\BlockContinueParserInterface;
use League\CommonMark\Parser\Cursor;

final class SimpleBlockParser extends AbstractBlockContinueParser
{
    private array $lines = [];

    public function __construct(private SimpleBlock $block) {}

    public function getBlock(): SimpleBlock
    {
        return $this->block;
    }

    public function tryContinue(Cursor $cursor, BlockContinueParserInterface $activeBlockParser): ?BlockContinue
    {
        if ($cursor->isIndented() || ! $cursor->isBlank()) {
            return BlockContinue::at($cursor);
        }

        return BlockContinue::none();
    }

    public function isContainer(): bool
    {
        return true; // Allow this block to contain other blocks
    }

    public function canContain(AbstractBlock $childBlock): bool
    {
        return true; // Allow any type of child block
    }

    public function addLine(string $line): void
    {
        $this->lines[] = $line;
    }

    public function closeBlock(): void {}
}
