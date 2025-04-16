<?php

namespace App\Domains\Website\Services\Contracts;

use App\Domains\Articles\Models\Author;
use App\Domains\Utils\ValueObjects\WebsiteContent;

interface AuthorService
{
    public function fromWebsiteContent(WebsiteContent $content): Author;
}
