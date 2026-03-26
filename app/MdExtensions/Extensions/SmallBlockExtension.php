<?php

namespace App\MdExtensions\Extensions;

use App\MdExtensions\Nodes\SmallBlock;
use App\MdExtensions\Parsing\SimpleBlockParser;
use App\MdExtensions\Parsing\SimpleBlockStartParcer;
use App\MdExtensions\Renderers\SimpleBlockRenderer;
use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Extension\ExtensionInterface;

final class SmallBlockExtension implements ExtensionInterface
{
    public function register(EnvironmentBuilderInterface $environment): void
    {
        $environment
            ->addBlockStartParser(
                new SimpleBlockStartParcer(
                    new SimpleBlockParser(new SmallBlock),
                    '/^-#\s*/',
                ),
                80
            )
            ->addRenderer(
                SmallBlock::class,
                new SimpleBlockRenderer('div', ['data-el' => 'small'])
            );
    }
}
