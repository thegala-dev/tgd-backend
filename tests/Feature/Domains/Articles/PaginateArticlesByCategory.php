<?php

namespace Tests\Feature\Domains\Articles;

use App\Domains\Articles\Models\Article;
use App\Domains\Website\Enums\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PaginateArticlesByCategory extends TestCase
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
        $response = $this->get(route('articles.by-category', [
            'category' => Category::PRODUCT,
        ]), $headers);

        $response->assertBadRequest();
    }

    public function test_request_returns_paginated_results()
    {
        Article::factory()->count(3)->withCategories([Category::TECH, Category::PRODUCT])->withAuthor()->withTags()->create();
        Article::factory()->count(3)->withCategories([Category::PRODUCT, Category::TUTORAL])->withAuthor()->withTags()->create();

        $response = $this->getJson(route('articles.by-category', [
            'category' => Category::PRODUCT,
        ]));

        $response->assertOk();
        $response->assertJsonCount(6, 'data');
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
