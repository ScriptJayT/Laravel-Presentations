<?php

namespace App\Enums;

enum Visibility
{
    case PUBLIC;
    case PRIVATE;
    case PROTECTED;

    public function title(): string
    {
        return match ($this) {
            self::PUBLIC => 'public',
            self::PROTECTED => 'protected',
            self::PRIVATE => 'private',
        };
    }
}
