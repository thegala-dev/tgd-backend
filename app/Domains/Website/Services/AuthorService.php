<?php

namespace App\Domains\Website\Services;

use App\Domains\Articles\Models\Author;
use App\Domains\Utils\ValueObjects\WebsiteContent;
use Illuminate\Contracts\Database\Eloquent\Builder;

class AuthorService implements Contracts\AuthorService
{
    public function fromWebsiteContent(WebsiteContent $content): Author
    {
        return Author::query()
            ->whereHas(
                'user',
                fn (Builder $query) => $query->where('email', $content->frontMatter->author->email)
            )->firstOrFail();
    }
}
