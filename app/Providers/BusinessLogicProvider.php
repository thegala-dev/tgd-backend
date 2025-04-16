<?php

namespace App\Providers;

use App\Domains\Articles\Services\ArticleService;
use App\Domains\Articles\Services\Contracts\ArticleService as ArticleServiceContract;
use App\Domains\Utils\Markdown\Contracts\MarkdownParser as MarkdownParserContract;
use App\Domains\Utils\Markdown\MarkdownParser;
use App\Domains\Website\Services\AuthorService;
use App\Domains\Website\Services\Contracts\AuthorService as AuthorServiceContract;
use App\Domains\Website\Services\Contracts\TagService as TagServiceContract;
use App\Domains\Website\Services\TagService;
use Illuminate\Support\ServiceProvider;

class BusinessLogicProvider extends ServiceProvider
{
    protected array $services = [
        MarkdownParserContract::class => MarkdownParser::class,
        ArticleServiceContract::class => ArticleService::class,
        AuthorServiceContract::class => AuthorService::class,
        TagServiceContract::class => TagService::class,
    ];

    public function register(): void
    {
        foreach ($this->services as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }

    public function boot(): void
    {
        //
    }
}
