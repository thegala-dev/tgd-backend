<?php

namespace App\Domains\Articles\Services\Contracts;

use App\Domains\Articles\Dto\Pagination;
use App\Domains\Articles\Models\Article;
use App\Domains\Utils\ValueObjects\WebsiteContent;
use App\Domains\Website\Enums\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ArticleService
{
    public function fromWebsiteContent(WebsiteContent $content): Article;

    /**
     * @param Pagination $pagination
     * @param array<string> $relations
     * @return LengthAwarePaginator
     */
    public function paginate(Pagination $pagination, array $relations): LengthAwarePaginator;

    /**
     * @param Pagination $pagination
     * @param array<Category> $categories
     * @param array<string> $relations
     * @return LengthAwarePaginator
     */
    public function byCategory(Pagination $pagination, array $categories, array $relations): LengthAwarePaginator;
}
