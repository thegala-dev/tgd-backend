<?php

namespace App\Models\Concerns;

use App\Models\BaseModel;
use Illuminate\Support\Str;

/**
 * @mixin BaseModel
 */
trait HasSlug
{
    const string DEFAULT_SLUG_ATTRIBUTE = 'name';

    const string DEFAULT_SLUG_COLUMN = 'slug';

    public function getSlugColumn(): string
    {
        return $this->slugColumn ?? self::DEFAULT_SLUG_COLUMN;
    }

    public function getSlugSourceAttribute(): string
    {
        return $this->slugAttribute ?? self::DEFAULT_SLUG_ATTRIBUTE;
    }

    protected static function bootHasSlug(): void
    {
        static::creating(function (BaseModel $model) {
            /** @var BaseModel|HasSlug $model */
            if (empty($model->getAttribute($model->getSlugColumn()))) {
                $model->setAttribute($model->getSlugColumn(), static::generateUniqueSlug($model));
            }
        });
    }

    protected static function generateUniqueSlug(BaseModel $model): string
    {
        /** @var BaseModel|HasSlug $model */
        $baseSlug = Str::slug($model->getSlugSource());

        $existingSlugs = $model::withTrashed()
            ->where($model->getSlugColumn(), 'like', $baseSlug.'%')
            ->pluck($model->getSlugColumn())
            ->toArray();

        if (empty($existingSlugs)) {
            return $baseSlug;
        }

        $maxSuffix = -1;
        foreach ($existingSlugs as $slug) {
            if ($slug === $baseSlug) {
                $maxSuffix = max($maxSuffix, 0);

                continue;
            }

            if (preg_match('/^'.preg_quote($baseSlug, '/').'-(\d+)$/', $slug, $matches)) {
                $maxSuffix = max($maxSuffix, (int) $matches[1]);
            }
        }

        // Increment to get the next available slug
        return $maxSuffix >= 0
            ? "{$baseSlug}-".($maxSuffix + 1)
            : $baseSlug;
    }

    protected function getSlugSource(): string
    {
        return $this->getAttribute($this->getSlugSourceAttribute()) ?? (string) Str::ulid();
    }
}
