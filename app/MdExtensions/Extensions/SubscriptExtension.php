<?php

namespace App\MdExtensions\Extensions;

use App\MdExtensions\Nodes\Subscript;
use App\MdExtensions\Parsing\BracketedInlineParser;
use App\MdExtensions\Renderers\SimpleInlineRenderer;
use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Extension\ExtensionInterface;

final class SubscriptExtension implements ExtensionInterface
{
    public function register(EnvironmentBuilderInterface $environment): void
    {
        $environment
            ->addInlineParser(new BracketedInlineParser('~', Subscript::class, true), 100)
            ->addRenderer(Subscript::class, new SimpleInlineRenderer('sub'));
    }
}
