<?php

namespace App\MdExtensions\Extensions;

use App\MdExtensions\Processors\SimpleDelimiterProcessor;
use App\MdExtensions\Renderers\SimpleDelimitRenderer;
use Exception;
use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Extension\ExtensionInterface;

abstract class BaseDelimiterExtension implements ExtensionInterface
{
    protected string $delimitedClassName;

    protected string $mdCharacter;

    protected string $htmlCharacter;

    protected int $mdCharacterCount = 1;

    protected array $htmlAttributes = [];

    public function register(EnvironmentBuilderInterface $env): void
    {
        if (! $this->delimitedClassName) {
            throw new Exception;
        }
        if (! $this->htmlCharacter) {
            throw new Exception;
        }
        if (! $this->mdCharacter) {
            throw new Exception;
        }
        if ($this->mdCharacterCount < 1) {
            throw new Exception;
        }

        $env->addDelimiterProcessor(new SimpleDelimiterProcessor(
            character: $this->mdCharacter,
            minLength: $this->mdCharacterCount,
            delimitedClass: $this->delimitedClassName,
        ));
        $env->addRenderer(
            $this->delimitedClassName,
            new SimpleDelimitRenderer(
                htmlTag: $this->htmlCharacter,
                htmlAttributes: $this->htmlAttributes,
            )
        );
    }
}
