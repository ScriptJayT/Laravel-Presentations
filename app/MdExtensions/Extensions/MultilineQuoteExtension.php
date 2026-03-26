<?php

namespace App\MdExtensions\Extensions;

use App\MdExtensions\Parsing\Blockquote;
use App\MdExtensions\Parsing\SimpleBlockStartParser;
use App\MdExtensions\Renderers\SimpleBlockRenderer;
use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Extension\ExtensionInterface;

class MultilineQuoteExtension implements ExtensionInterface
{
    public function register(EnvironmentBuilderInterface $env): void
    {
        $env->addBlockStartParser(new SimpleBlockStartParser('/^\>\>\>+/'));
        $env->addRenderer(
            Blockquote::class,
            new SimpleBlockRenderer('blockquote', ['data-el' => 'multiline-quote'])
        );
    }
}
