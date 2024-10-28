<?php

namespace Http\models\data\enum;

enum Has: string
{
    case Yes = 'Yes';
    case No = 'No';
    case Unspecified = 'Unspecified';

    public static function fromValue(?int $value): self
    {
        return match ($value) {
            1 => self::Yes,
            0 => self::No,
            default => self::Unspecified,
        };
    }
}
