<?php

namespace App\MdExtensions\Processors;

use App\MdExtensions\Parsing\UnderlineDelimiter as Delimiter;
use League\CommonMark\Delimiter\DelimiterInterface;
use League\CommonMark\Delimiter\Processor\DelimiterProcessorInterface;
use League\CommonMark\Node\Inline\AbstractStringContainer;

class UnderlineDelimiterProcessor implements DelimiterProcessorInterface
{
    public function getOpeningCharacter(): string
    {
        return '_';
    }

    public function getClosingCharacter(): string
    {
        return '_';
    }

    public function getMinLength(): int
    {
        return 2;
    }

    public function getDelimiterUse(DelimiterInterface $opener, DelimiterInterface $closer): int
    {
        if ($opener->getLength() > 2 && $closer->getLength() > 2) {
            return 0;
        }
        if ($opener->getLength() !== $closer->getLength()) {
            return 0;
        }

        // $opener and $closer are the same length so we just return one of them
        return $opener->getLength();
    }

    public function process(AbstractStringContainer $opener, AbstractStringContainer $closer, int $delimiterUse): void
    {
        $deli = new Delimiter(\str_repeat('_', $delimiterUse));
        $next = $opener->next();
        while ($next !== null && $next !== $closer) {
            $tmp = $next->next();
            $deli->appendChild($next);
            $next = $tmp;
        }
        $opener->insertAfter($deli);
    }

    public function getCacheKey(DelimiterInterface $closer): string
    {
        return "_{$closer->getLength()}";
    }
}
