<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\StoreFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property string $image
 * @property string $link
 * @property bool $is_top
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 * @property ?Carbon $deleted_at
 * @property Promotion[] $promotions
 */
class Store extends Model
{
    /** @use HasFactory<StoreFactory> */
    use HasFactory, SoftDeletes;

    public $timestamps = false;
    protected $fillable = ['id', 'name', 'link', 'image'];

    protected function casts(): array
    {
        return [
            'is_top' => 'boolean',
        ];
    }

    public function promotions(): HasMany
    {
        return $this->hasMany(Promotion::class);
    }
}
