<?php

namespace App\MdExtensions\Nodes;

use League\CommonMark\Node\Inline\AbstractInline;
use League\CommonMark\Node\Inline\DelimitedInterface;

abstract class SimpleDelimiter extends AbstractInline implements DelimitedInterface
{
    public function __construct(private string $delimiter)
    {
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
