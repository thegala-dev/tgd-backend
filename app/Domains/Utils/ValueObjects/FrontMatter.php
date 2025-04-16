<?php

namespace App\Domains\Utils\ValueObjects;

use App\Domains\Website\Enums\Category;
use App\Domains\Website\Enums\Drawer;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;
use JsonSerializable;

readonly class FrontMatter implements Arrayable, Jsonable, JsonSerializable
{
    /**
     * @param  Collection<Category>  $categories
     * @param  Collection<Tag>  $tags
     */
    public function __construct(
        public string $slug,
        public string $title,
        public string $description,
        public ?string $hero,
        public ?Drawer $drawer,
        public Collection $categories,
        public Collection $tags,
        public Author $author,
        public ?DateTimeInterface $publishedAt = null,
    ) {}

    public static function from(array $data): FrontMatter
    {
        $drawer = $data['drawer'];
        if (is_string($drawer)) {
            $drawer = Drawer::from($drawer);
        }

        return new self(
            slug: $data['slug'],
            title: $data['title'],
            description: $data['description'],
            hero: $data['hero'] ?? null,
            drawer: $drawer,
            categories: collect($data['categories'])->map(fn (string $category) => Category::from($category)),
            tags: collect($data['tags'])->map(fn (array $tag) => Tag::from($tag)),
            author: Author::from($data['author']),
            publishedAt: $data['publishedAt'] !== null ? Carbon::make($data['publishedAt']) : now(),
        );
    }

    public function toArray(): array
    {
        return [
            'slug' => $this->slug,
            'title' => $this->title,
            'description' => $this->description,
            'hero' => $this->hero,
            'drawer' => $this->drawer->value,
            'categories' => $this->categories->toArray(),
            'tags' => $this->tags->toArray(),
            'author' => $this->author->toArray(),
            'publishedAt' => $this->publishedAt,
        ];
    }

    public function toJson($options = 0): false|string
    {
        return json_encode($this->toArray(), $options);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
