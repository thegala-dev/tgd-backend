<?php

namespace App\Domains\Website\Enums;

use App\Traits\EnumHelpers;

enum Drawer: string
{
    use EnumHelpers;

    case DEFAULT = 'default';

    case ARTICLES = 'articles';
}
