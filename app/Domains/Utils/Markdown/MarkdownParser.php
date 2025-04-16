<?php

namespace App\Domains\Utils\Markdown;

use App\Domains\Articles\Services\Contracts\ArticleService;
use App\Domains\Utils\ValueObjects\WebsiteContent;
use App\Domains\Website\Enums\PageType;
use RuntimeException;

class MarkdownParser implements Contracts\MarkdownParser
{
    public function parse(WebsiteContent $content, PageType $pageType): void
    {
        switch ($pageType) {
            case PageType::ARTICLE:
                $this->parseArticle($content);
                break;
            default:
                throw new RuntimeException("Page type {$pageType->value} not supported");
        }
    }

    private function parseArticle(WebsiteContent $content): void
    {
        /** @var ArticleService $articleService */
        $articleService = app()->make(ArticleService::class);
        $articleService->fromWebsiteContent($content);
    }
}
