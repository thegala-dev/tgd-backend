<?php

namespace Tests\Unit\Domains\Website\Services;

use App\Domains\Articles\Models\Article;
use App\Domains\Website\Services\AuthorService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_retrieves_author_from_website_content()
    {
        $article = Article::factory()->withAuthor()->withTags()->create();

        $service = new AuthorService;

        $result = $service->fromWebsiteContent($article->toValueObject());

        $this->assertTrue($article->author->is($result));
    }
}
