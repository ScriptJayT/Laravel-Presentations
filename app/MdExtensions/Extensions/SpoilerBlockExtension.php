<?php

namespace App\MdExtensions\Extensions;

use App\MdExtensions\Nodes\SpoilerBlock;
use App\MdExtensions\Parsing\SimpleBlockParser;
use App\MdExtensions\Parsing\SimpleBlockStartParcer;
use App\MdExtensions\Renderers\SimpleBlockRenderer;
use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Extension\ExtensionInterface;

final class SpoilerBlockExtension implements ExtensionInterface
{
    public function register(EnvironmentBuilderInterface $environment): void
    {
        $environment
            ->addBlockStartParser(
                new SimpleBlockStartParcer(
                    new SimpleBlockParser(new SpoilerBlock),
                    '/^\|\|\|\s*/',
                ),
                80
            )
            ->addRenderer(
                SpoilerBlock::class,
                new SimpleBlockRenderer('div', ['data-el' => 'spoiler'])
            );
    }
}
