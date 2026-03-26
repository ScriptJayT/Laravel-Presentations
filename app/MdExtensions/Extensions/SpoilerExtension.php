<?php

namespace App\MdExtensions\Extensions;

use App\MdExtensions\Nodes\Spoiler;

final class SpoilerExtension extends BaseDelimiterExtension
{
    protected string $htmlCharacter = 'span';

    protected array $htmlAttributes = ['data-el' => 'spoiler'];

    protected string $delimitedClassName = Spoiler::class;

    protected string $mdCharacter = '|';

    protected int $mdCharacterCount = 2;
}
