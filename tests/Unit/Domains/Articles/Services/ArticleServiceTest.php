<?php

namespace Tests\Unit\Domains\Articles\Services;

use App\Domains\Articles\Models\Article;
use App\Domains\Articles\Models\Author;
use App\Domains\Articles\Models\Tag;
use App\Domains\Articles\Services\ArticleService;
use App\Domains\Website\Services\Contracts\AuthorService;
use App\Domains\Website\Services\TagService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;

class ArticleServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_article_from_website_content()
    {
        $article = Article::factory()->withAuthor()->withTags()->create();
        $websiteContent = $article->toValueObject();

        $article->tags()->detach();
        $article->forceDelete();

        $service = new ArticleService(
            $this->mock(AuthorService::class, function (MockInterface $mock) use ($websiteContent) {
                $mock->shouldReceive('fromWebsiteContent')
                    ->once()
                    ->with($websiteContent)
                    ->andReturn(Author::first());
            }),
            $this->mock(TagService::class, function (MockInterface $mock) use ($websiteContent) {
                $mock->shouldReceive('fromWebsiteContent')
                    ->once()
                    ->with($websiteContent)
                    ->andReturn(Tag::all());
            }),
        );

        $result = $service->fromWebsiteContent($websiteContent);

        $this->assertInstanceOf(Article::class, $result);
        $this->assertModelExists($result);
    }
}
