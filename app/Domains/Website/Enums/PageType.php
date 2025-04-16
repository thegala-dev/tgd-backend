<?php

namespace App\Domains\Website\Enums;

use App\Traits\EnumHelpers;

enum PageType: string
{
    use EnumHelpers;

    case ARTICLE = 'article';
}
