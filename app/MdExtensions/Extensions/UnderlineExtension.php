<?php

namespace App\MdExtensions\Extensions;

use App\MdExtensions\Parsing\UnderlineDelimiter as Delimiter;
use App\MdExtensions\Processors\UnderlineDelimiterProcessor as DelimiterProcessor;
use App\MdExtensions\Renderers\UnderlineRenderer as Renderer;
use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Extension\ExtensionInterface;

class UnderlineExtension implements ExtensionInterface
{
    public function register(EnvironmentBuilderInterface $env): void
    {
        $env->addDelimiterProcessor(new DelimiterProcessor);
        $env->addRenderer(Delimiter::class, new Renderer);
    }
}
