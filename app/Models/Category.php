<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $icon
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 */
class Category extends Model
{
    use HasFactory;

    public function promotions(): BelongsToMany
    {
        return $this->belongsToMany(Promotion::class)->using(CategoryPromotion::class);
    }
}
