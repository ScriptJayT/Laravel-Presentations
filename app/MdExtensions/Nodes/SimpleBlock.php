<?php

namespace App\MdExtensions\Nodes;

use League\CommonMark\Node\Block\AbstractBlock;

abstract class SimpleBlock extends AbstractBlock
{
    public function __construct()
    {
        parent::__construct();
    }
}
