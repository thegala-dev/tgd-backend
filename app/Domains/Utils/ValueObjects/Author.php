<?php

namespace App\Domains\Utils\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

readonly class Author implements Arrayable, Jsonable, JsonSerializable
{
    public function __construct(
        public string $email,
        public string $name,
    ) {}

    public static function from(array $author): Author
    {
        return new self(
            email: $author['email'],
            name: $author['name'],
        );
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'name' => $this->name,
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
