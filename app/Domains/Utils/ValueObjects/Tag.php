<?php

namespace App\Domains\Utils\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

readonly class Tag implements Arrayable, Jsonable, JsonSerializable
{
    public function __construct(
        public string $slug,
        public string $label,
    ) {}

    public static function from(array $tag): Tag
    {
        return new self(
            slug: $tag['slug'],
            label: $tag['label'],
        );
    }

    public function toArray(): array
    {
        return [
            'slug' => $this->slug,
            'label' => $this->label,
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
