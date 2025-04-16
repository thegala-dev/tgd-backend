<?php

namespace Tests\Unit\Domains\Utils\Markdown;

use App\Domains\Articles\Models\Article;
use App\Domains\Utils\Markdown\MarkdownParser;
use App\Domains\Website\Enums\PageType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MarkdownParserTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_parses_article()
    {
        /** @var Article $article */
        $article = Article::factory()->withAuthor()->create();
        $websiteContent = $article->toValueObject();

        $article->tags()->detach();
        $article->forceDelete();

        $parser = new MarkdownParser;
        $parser->parse($websiteContent, PageType::ARTICLE);

        $this->assertDatabaseHas('articles', [
            'slug' => $article->slug,
        ]);
    }
}
