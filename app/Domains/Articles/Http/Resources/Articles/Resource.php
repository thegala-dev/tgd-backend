<?php

namespace App\Domains\Articles\Http\Resources\Articles;

use App\Domains\Articles\Http\Resources\Authors\Resource as AuthorResource;
use App\Domains\Articles\Http\Resources\Tags\ResourceCollection as TagCollection;
use App\Domains\Articles\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Article
 */
class Resource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'markdown' => $this->markdown,
            'hero' => $this->hero,
            'drawer' => $this->drawer,
            'categories' => $this->categories,
            'published_at' => $this->published_at,
            'author' => $this->whenLoaded('author', fn () => new AuthorResource($this->author)),
            'tags' => $this->whenLoaded('tags', fn () => new TagCollection($this->tags)),
            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->updated_at->toISOString(),
        ];
    }
}
