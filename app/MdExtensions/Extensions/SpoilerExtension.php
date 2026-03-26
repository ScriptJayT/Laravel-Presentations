<?php

namespace App\MdExtensions\Extensions;

use App\MdExtensions\Nodes\Spoiler;
use App\MdExtensions\Processors\SimpleDelimiterProcessor;
use App\MdExtensions\Renderers\SimpleRenderer;
use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Extension\ExtensionInterface;

class SpoilerExtension implements ExtensionInterface
{
    public function register(EnvironmentBuilderInterface $env): void
    {
        $env->addDelimiterProcessor(new SimpleDelimiterProcessor('|', 2, Spoiler::class));
        $env->addRenderer(Spoiler::class, new SimpleRenderer('span', ['data-el' => 'spoiler']));
    }
}
