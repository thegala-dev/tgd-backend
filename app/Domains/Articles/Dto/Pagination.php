<?php

namespace App\Domains\Articles\Dto;

use Illuminate\Http\Request;

readonly class Pagination
{
    public function __construct(
        public ?int $page = 1,
        public ?int $perPage = 10,
    ) {}

    public static function from(Request $request): Pagination
    {
        return new self(
            page: $request->query('page'),
            perPage: $request->query('perPage'),
        );
    }
}
