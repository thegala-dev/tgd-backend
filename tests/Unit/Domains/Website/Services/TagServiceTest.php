<?php

namespace Tests\Unit\Domains\Website\Services;

use App\Domains\Articles\Models\Article;
use App\Domains\Articles\Models\Tag;
use App\Domains\Website\Services\TagService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_retrieves_tags_from_website_content()
    {
        $article = Article::factory()->withAuthor()->withTags()->create();

        $service = new TagService;

        $result = $service->fromWebsiteContent($article->toValueObject());
        $this->assertEquals($result->count(), $article->tags->count());

        $article->tags->each(function (Tag $tag) use ($result) {
            $this->assertTrue($result->contains($tag));
        });
    }
}
