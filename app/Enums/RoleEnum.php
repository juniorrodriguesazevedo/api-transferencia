<?php

namespace App\Enums;

class RoleEnum
{
    const CLIENT = 1;
    const SHOPKEEPER = 2;

    public static function getAttribute($attribute): array | null
    {
        $values = [
            'CLIENT' => self::CLIENT,
            'SHOPKEEPER' => self::SHOPKEEPER,
        ];

        return $values[$attribute] ?? null;
    }

    public static function values(): array
    {
        return [
            self::CLIENT => 1,
            self::SHOPKEEPER => 2,
        ];
    }
}
