<?php

namespace App\Domains\Website\Services;

use App\Domains\Articles\Models\Tag;
use App\Domains\Utils\ValueObjects\WebsiteContent;
use Illuminate\Support\Collection;

class TagService implements Contracts\TagService
{
    public function fromWebsiteContent(WebsiteContent $content): Collection
    {
        return Tag::query()
            ->whereIn('slug', $content->frontMatter->tags->pluck('slug')->toArray())
            ->get();
    }
}
