<?php

namespace App\Domains\Articles\Services;

use App\Domains\Articles\Models\Article;
use App\Domains\Utils\ValueObjects\WebsiteContent;
use App\Domains\Website\Services\Contracts\AuthorService;
use App\Domains\Website\Services\Contracts\TagService;

class ArticleService implements Contracts\ArticleService
{
    public function __construct(
        private readonly AuthorService $authorService,
        private readonly TagService $tagService,
    ) {}

    public function fromWebsiteContent(WebsiteContent $content): Article
    {
        $author = $this->authorService->fromWebsiteContent($content);
        $tags = $this->tagService->fromWebsiteContent($content);

        $article = new Article([
            'title' => $content->frontMatter->title,
            'slug' => $content->frontMatter->slug,
            'description' => $content->frontMatter->description,
            'markdown' => $content->markdown,
            'hero' => $content->frontMatter->hero,
            'drawer' => $content->frontMatter->drawer,
            'categories' => $content->frontMatter->categories,
            'published_at' => $content->frontMatter->publishedAt ?: now(),
        ]);

        $article->author()->associate($author);

        return tap($article, function (Article $article) use ($tags) {
            $article->saveQuietly();
            $article->tags()->attach($tags);
        });
    }
}
