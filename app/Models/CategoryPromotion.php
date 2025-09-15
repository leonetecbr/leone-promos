<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property int $category_id
 * @property int $promotion_id
 * @property Category $category[
 * @property Promotion $promotion
 */
class CategoryPromotion extends Pivot
{
    const ?string UPDATED_AT = null;

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function promotion(): BelongsTo
    {
        return $this->belongsTo(Promotion::class);
    }
}
