<?php

namespace App\Domains\Articles\Models;

use App\Domains\Utils\ValueObjects\WebsiteContent;
use App\Domains\Website\Enums\Category;
use App\Domains\Website\Enums\Drawer;
use App\Models\BaseModel;
use App\Models\Concerns\HasSlug;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property string $author_id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string $markdown
 * @property string|null $hero
 * @property Drawer $drawer
 * @property \Illuminate\Support\Collection<int, Category>|null $categories
 * @property Carbon|null $published_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read \App\Domains\Articles\Models\Author $author
 * @property-read Collection<int, \App\Domains\Articles\Models\Tag> $tags
 * @property-read int|null $tags_count
 *
 * @method static \Database\Factories\Domains\Articles\Models\ArticleFactory factory($count = null, $state = [])
 * @method static Builder<static>|Article newModelQuery()
 * @method static Builder<static>|Article newQuery()
 * @method static Builder<static>|Article onlyTrashed()
 * @method static Builder<static>|Article query()
 * @method static Builder<static>|Article whereAuthorId($value)
 * @method static Builder<static>|Article whereCategories($value)
 * @method static Builder<static>|Article whereCreatedAt($value)
 * @method static Builder<static>|Article whereDeletedAt($value)
 * @method static Builder<static>|Article whereDescription($value)
 * @method static Builder<static>|Article whereDrawer($value)
 * @method static Builder<static>|Article whereHero($value)
 * @method static Builder<static>|Article whereId($value)
 * @method static Builder<static>|Article whereMarkdown($value)
 * @method static Builder<static>|Article wherePublishedAt($value)
 * @method static Builder<static>|Article whereSlug($value)
 * @method static Builder<static>|Article whereTitle($value)
 * @method static Builder<static>|Article whereUpdatedAt($value)
 * @method static Builder<static>|Article withTrashed()
 * @method static Builder<static>|Article withoutTrashed()
 *
 * @mixin Eloquent
 */
class Article extends BaseModel
{
    use HasSlug;

    public string $slugAttribute = 'title';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'markdown',
        'hero',
        'drawer',
        'categories',
        'published_at',
    ];

    public function toValueObject(): WebsiteContent
    {
        return WebsiteContent::from(
            frontMatter: [
                'slug' => $this->slug,
                'title' => $this->title,
                'description' => $this->description,
                'hero' => $this->hero,
                'drawer' => $this->drawer,
                'categories' => $this->categories->map(fn (Category $category) => $category->value)->toArray(),
                'tags' => $this->tags->map(fn (Tag $tag) => $tag->toValueObject())->toArray(),
                'author' => $this->author->toValueObject()->toArray(),
                'publishedAt' => $this->published_at->toDateString(),
            ],
            markdown: $this->markdown
        );
    }

    protected function casts(): array
    {
        return [
            'drawer' => Drawer::class,
            'categories' => AsEnumCollection::of(Category::class),
            'published_at' => 'date:Y-m-d',
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function getSlugSourceAttribute(): string
    {
        return 'title';
    }
}
