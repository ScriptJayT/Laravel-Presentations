<?php

namespace App\MdExtensions\Extensions;

use App\MdExtensions\Nodes\Underline;

final class UnderlineExtension extends BaseDelimiterExtension
{
    protected string $htmlCharacter = 'u';

    protected string $delimitedClassName = Underline::class;

    protected string $mdCharacter = '_';

    protected int $mdCharacterCount = 2;
}
