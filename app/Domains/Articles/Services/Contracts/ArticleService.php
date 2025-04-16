<?php

namespace App\Domains\Articles\Services\Contracts;

use App\Domains\Articles\Models\Article;
use App\Domains\Utils\ValueObjects\WebsiteContent;

interface ArticleService
{
    public function fromWebsiteContent(WebsiteContent $content): Article;
}
