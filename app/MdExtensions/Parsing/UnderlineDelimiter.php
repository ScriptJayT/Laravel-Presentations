<?php

namespace App\MdExtensions\Parsing;

use League\CommonMark\Node\Inline\AbstractInline;
use League\CommonMark\Node\Inline\DelimitedInterface;

final class UnderlineDelimiter extends AbstractInline implements DelimitedInterface
{
    public function __construct(
        private string $delimiter = '__'
    ) {
        parent::__construct();
    }

    public function getOpeningDelimiter(): string
    {
        return $this->delimiter;
    }

    public function getClosingDelimiter(): string
    {
        return $this->delimiter;
    }
}
