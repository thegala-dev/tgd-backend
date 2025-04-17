<?php

namespace Tests\Feature\Domains\Articles;

use App\Domains\Articles\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PaginateArticles extends TestCase
{
    use RefreshDatabase;

    public static function jsonHeaders(): array
    {
        return [
            [[]],
            [['Accept' => 'application/json']],
            [['Content-Type' => 'application/json']],
        ];
    }

    #[DataProvider('jsonHeaders')]
    public function test_request_requires_json_headers(array $headers)
    {
        $response = $this->get(route('articles.index'), $headers);

        $response->assertBadRequest();
    }

    public function test_request_returns_paginated_results()
    {
        Article::factory()->count(3)->withAuthor()->withTags()->create();
        $response = $this->getJson(route('articles.index'));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                [
                    'title',
                    'slug',
                    'description',
                    'markdown',
                    'hero',
                    'drawer',
                    'categories',
                    'published_at',
                    'author' => ['name', 'slug', 'email'],
                    'tags' => [['slug', 'label']],
                    'created_at',
                    'updated_at',
                ]
            ]
        ]);
    }
}
