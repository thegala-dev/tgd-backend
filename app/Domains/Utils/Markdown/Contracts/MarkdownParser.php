<?php

namespace App\Domains\Utils\Markdown\Contracts;

use App\Domains\Utils\ValueObjects\WebsiteContent;
use App\Domains\Website\Enums\PageType;

interface MarkdownParser
{
    public function parse(WebsiteContent $content, PageType $pageType): void;
}
