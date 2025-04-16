<?php

namespace App\Traits;

use BackedEnum;
use InvalidArgumentException;
use UnitEnum;

trait EnumHelpers
{
    public static function toArray(bool $useValues = false): array
    {
        $enumClass = get_called_class();

        if (! enum_exists($enumClass)) {
            throw new InvalidArgumentException("Class {$enumClass} is not a valid enum.");
        }

        /** @var BackedEnum|UnitEnum $enumClass */
        $cases = $enumClass::cases();

        if (count($cases) === 0) {
            return [];
        }

        // Handle backed enums (string/int values) and pure enums (just names).
        if ($useValues && is_subclass_of($cases[0], BackedEnum::class)) {
            return array_map(fn (BackedEnum $case) => (string) $case->value, $cases);
        }

        // Use case names (works for both pure and backed enums if values aren't needed).
        return array_map(fn (UnitEnum $case) => $case->name, $cases);
    }
}
