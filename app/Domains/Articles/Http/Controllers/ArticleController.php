<?php

namespace App\Domains\Articles\Http\Controllers;

use App\Domains\Articles\Dto\Pagination;
use App\Domains\Articles\Http\Resources\Articles\ResourceCollection;
use App\Domains\Articles\Services\Contracts\ArticleService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request, ArticleService $articleService): ResourceCollection
    {
        return new ResourceCollection(
            $articleService->paginate(Pagination::from($request), ['author', 'tags'])
        );
    }

    public function byCategory(Request $request, ArticleService $articleService, string $category): ResourceCollection
    {
        return new ResourceCollection(
            $articleService->byCategory(Pagination::from($request), [$category], ['author', 'tags'])
        );
    }
}
