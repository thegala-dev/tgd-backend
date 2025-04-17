<?php

namespace App\Http\Resources\Concerns;

use Illuminate\Support\Arr;

trait FormatsMeta
{
    public function paginationInformation($request, $paginated, $default): array
    {
        return Arr::only($default, ['data', 'meta']);
    }
}
