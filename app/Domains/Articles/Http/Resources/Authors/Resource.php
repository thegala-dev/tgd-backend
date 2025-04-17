<?php

namespace App\Domains\Articles\Http\Resources\Authors;

use App\Domains\Articles\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Author
 */
class Resource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'email' => $this->user?->email ?: 'no-email@thegala.dev',
        ];
    }
}
