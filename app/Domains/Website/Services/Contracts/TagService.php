<?php

namespace App\Domains\Website\Services\Contracts;

use App\Domains\Articles\Models\Tag;
use App\Domains\Utils\ValueObjects\WebsiteContent;
use Illuminate\Support\Collection;

interface TagService
{
    /**
     * @return Collection<Tag>|array<Tag>
     */
    public function fromWebsiteContent(WebsiteContent $content): Collection|array;
}
