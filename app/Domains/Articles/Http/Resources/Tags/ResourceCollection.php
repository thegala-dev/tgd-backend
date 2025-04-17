<?php

namespace App\Domains\Articles\Http\Resources\Tags;

use App\Http\Resources\Concerns\FormatsMeta;
use Illuminate\Http\Resources\Json\ResourceCollection as JsonResourceCollection;

class ResourceCollection extends JsonResourceCollection
{
    use FormatsMeta;

    public $collects = Resource::class;
}
