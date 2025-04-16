<?php

namespace App\Domains\Articles\Models;

use App\Domains\Utils\ValueObjects\Tag as ValueObject;
use App\Models\BaseModel;
use App\Models\Concerns\HasSlug;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property string $id
 * @property string $label
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $commentable
 *
 * @method static \Database\Factories\Domains\Articles\Models\TagFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Tag extends BaseModel
{
    use HasSlug;

    public string $slugAttribute = 'label';

    protected $fillable = [
        'label',
        'slug',
    ];

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function toValueObject(): ValueObject
    {
        return ValueObject::from([
            'label' => $this->label,
            'slug' => $this->slug,
        ]);
    }
}
