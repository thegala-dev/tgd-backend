<?php

namespace App\Domains\Utils\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

readonly class WebsiteContent implements Arrayable, Jsonable, JsonSerializable
{
    public function __construct(
        public FrontMatter $frontMatter,
        public string $markdown,
    ) {}

    public static function from(array $frontMatter, string $markdown): WebsiteContent
    {
        return new self(
            frontMatter: FrontMatter::from($frontMatter),
            markdown: $markdown);
    }

    public function toArray(): array
    {
        return [
            'frontMatter' => $this->frontMatter->toArray(),
            'markdown' => $this->markdown,
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
