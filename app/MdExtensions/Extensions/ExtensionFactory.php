<?php

namespace App\MdExtensions\Extensions;

use App\MdExtensions\Parsing\SimpleDelimiter;
use App\MdExtensions\Processors\SimpleDelimiterProcessor;
use App\MdExtensions\Renderers\SimpleRenderer;
use League\CommonMark\Delimiter\Processor\DelimiterProcessorInterface;
use League\CommonMark\Node\Inline\DelimitedInterface;

class ExtensionFactory
{
    public function __construct(
        private string $character,
        private int $minlength,
        private string $tag,
        private array $nodeAttributes = [],
    ) {}

    public function getRenderer()
    {
        return new SimpleRenderer(
            htmlTag: $this->tag,
            htmlAttributes: $this->nodeAttributes,
        );
    }

    public function getDelimiterProcessor(): DelimiterProcessorInterface
    {
        return new SimpleDelimiterProcessor(
            character: $this->character,
            minLength: $this->minlength,
            delimiter: fn ($char) => $this->getDelimiter($char),
        );
    }

    public function getDelimiter(?string $_delimiter = null): DelimitedInterface
    {
        return new SimpleDelimiter($_delimiter ?? $this->character);
    }
}
