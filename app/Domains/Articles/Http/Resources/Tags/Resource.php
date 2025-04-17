<?php

namespace App\Domains\Articles\Http\Resources\Tags;

use App\Domains\Articles\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Tag
 */
class Resource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'slug' => $this->slug,
            'label' => $this->label,
        ];
    }
}
