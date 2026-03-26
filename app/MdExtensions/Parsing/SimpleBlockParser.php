<?php

namespace App\MdExtensions\Parsing;

use App\MdExtensions\Nodes\SimpleBlock;
use App\MdExtensions\Nodes\SmallBlock;
use League\CommonMark\Parser\Block\AbstractBlockContinueParser;
use League\CommonMark\Parser\Block\BlockContinue;
use League\CommonMark\Parser\Block\BlockContinueParserInterface;
use League\CommonMark\Parser\Cursor;

final class SimpleBlockParser extends AbstractBlockContinueParser
{
    private array $lines = [];

    public function __construct(private SimpleBlock $block) {}

    public function getBlock(): SmallBlock
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

    public function addLine(string $line): void
    {
        $this->lines[] = $line;
    }

    public function closeBlock(): void
    {
        $content = implode("\n", $this->lines);
        $this->block->setContent(trim($content));
    }
}
