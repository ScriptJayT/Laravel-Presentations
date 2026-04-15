<?php

namespace App\MdExtensions\Extensions;

use App\MdExtensions\Nodes\Superscript;
use App\MdExtensions\Parsing\BracketedInlineParser;
use App\MdExtensions\Renderers\SimpleInlineRenderer;
use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Extension\ExtensionInterface;

final class SuperscriptExtension implements ExtensionInterface
{
    public function register(EnvironmentBuilderInterface $environment): void
    {
        $environment
            ->addInlineParser(new BracketedInlineParser('^', Superscript::class, true), 100)
            ->addRenderer(Superscript::class, new SimpleInlineRenderer('sup'));
    }
}
