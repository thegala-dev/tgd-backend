<?php

namespace App\Domains\Articles\Models;

use App\Domains\Utils\ValueObjects\Author as ValueObject;
use App\Models\BaseModel;
use App\Models\Concerns\HasSlug;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property string|null $user_id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read User|null $user
 *
 * @method static \Database\Factories\Domains\Articles\Models\AuthorFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Author extends BaseModel
{
    use HasSlug;

    protected string $slugAttribute = 'name';

    protected $fillable = [
        'name',
        'slug',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function toValueObject(): ValueObject
    {
        return ValueObject::from([
            'name' => $this->name,
            'email' => $this->user->email,
        ]);
    }
}
