<?php

namespace App\MdExtensions\Nodes;

use League\CommonMark\Node\Inline\AbstractInline;

abstract class SimpleInline extends AbstractInline
{
    public function __construct(private string $content = '')
    {
        parent::__construct();
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
