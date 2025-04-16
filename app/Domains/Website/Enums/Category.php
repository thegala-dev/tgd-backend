<?php

namespace App\Domains\Website\Enums;

use App\Traits\EnumHelpers;

enum Category: string
{
    use EnumHelpers;

    case TECH = 'technology';
    case PRODUCT = 'product';
    case TUTORAL = 'tutorial';
    case G_SHARP = 'g-sharp';
}
