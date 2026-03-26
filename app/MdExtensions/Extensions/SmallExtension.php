<?php

namespace App\MdExtensions\Extensions;

use App\MdExtensions\Nodes\Small;

final class SmallExtension extends BaseDelimiterExtension
{
    protected string $htmlCharacter = 'small';

    protected string $delimitedClassName = Small::class;

    protected string $mdCharacter = '-';

    protected int $mdCharacterCount = 2;
}
