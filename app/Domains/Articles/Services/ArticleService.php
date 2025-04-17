<?php

namespace App\Domains\Articles\Services;

use App\Domains\Articles\Dto\Pagination;
use App\Domains\Articles\Models\Article;
use App\Domains\Utils\ValueObjects\WebsiteContent;
use App\Domains\Website\Services\Contracts\AuthorService;
use App\Domains\Website\Services\Contracts\TagService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

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

    public function paginate(Pagination $pagination, array $relations): LengthAwarePaginator
    {
        return $this->newArticlesQuery()
            ->with($relations)
            ->paginate(
                perPage: $pagination->perPage,
                page: $pagination->page
            );
    }

    public function byCategory(Pagination $pagination, array $categories, array $relations): LengthAwarePaginator
    {
        return $this->newArticlesQuery()
            ->withCategories([$categories])
            ->with($relations)
            ->paginate(
                perPage: $pagination->perPage,
                page: $pagination->page
            );
    }

    protected function newArticlesQuery(): Article|Builder
    {
        return Article::query()->orderBy('published_at', 'desc');
    }
}
