<?php

namespace App\MdExtensions\Processors;

use League\CommonMark\Delimiter\DelimiterInterface;
use League\CommonMark\Delimiter\Processor\DelimiterProcessorInterface;
use League\CommonMark\Node\Inline\AbstractStringContainer;

class SimpleDelimiterProcessor implements DelimiterProcessorInterface
{
    public function __construct(
        private string $character,
        private int $minLength,
        private string $delimitedClass,
    ) {}

    public function getOpeningCharacter(): string
    {
        return $this->character;
    }

    public function getClosingCharacter(): string
    {
        return $this->character;
    }

    public function getMinLength(): int
    {
        return $this->minLength;
    }

    public function getDelimiterUse(DelimiterInterface $opener, DelimiterInterface $closer): int
    {
        if (
            $opener->getLength() > $this->minLength
            && $closer->getLength() > $this->minLength
        ) {
            return 0;
        }
        if ($opener->getLength() !== $closer->getLength()) {
            return 0;
        }
        if ($opener->getChar() !== $this->character) {
            return 0;
        }

        return $opener->getLength();
    }

    public function process(
        AbstractStringContainer $opener,
        AbstractStringContainer $closer,
        int $delimiterUse,
    ): void {
        $deli = new $this->delimitedClass(str_repeat($this->character, $delimiterUse));
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
        return "{$closer->getChar()}{$closer->getLength()}";
    }
}
