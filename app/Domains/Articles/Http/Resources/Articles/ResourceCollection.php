<?php

namespace App\Domains\Articles\Http\Resources\Articles;

use App\Http\Resources\Concerns\FormatsMeta;
use Illuminate\Http\Resources\Json\ResourceCollection as JsonResourceCollection;
use Illuminate\Support\Arr;

class ResourceCollection extends JsonResourceCollection
{
    use FormatsMeta;

    public $collects = Resource::class;
}
