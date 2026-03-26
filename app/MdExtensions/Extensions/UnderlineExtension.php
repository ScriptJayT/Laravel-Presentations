<?php

namespace App\MdExtensions\Extensions;

use App\MdExtensions\Nodes\Underline;
use App\MdExtensions\Processors\SimpleDelimiterProcessor;
use App\MdExtensions\Renderers\SimpleRenderer;
use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Extension\ExtensionInterface;

class UnderlineExtension implements ExtensionInterface
{
    public function register(EnvironmentBuilderInterface $env): void
    {
        $env->addDelimiterProcessor(new SimpleDelimiterProcessor('_', 2, Underline::class));
        $env->addRenderer(Underline::class, new SimpleRenderer('u'));
    }
}
