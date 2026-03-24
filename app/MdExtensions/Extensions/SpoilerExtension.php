<?php

namespace App\MdExtensions\Extensions;

use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Extension\ExtensionInterface;

class SpoilerExtension implements ExtensionInterface
{
    public function register(EnvironmentBuilderInterface $env): void
    {
        $factory = new ExtensionFactory('|', 2, 'span', ['data-el' => 'spoiler']);
        $env->addDelimiterProcessor($factory->getDelimiterProcessor());
        $env->addRenderer($factory->getDelimiter()::class, $factory->getRenderer());
    }
}
