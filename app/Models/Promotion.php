<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\PromotionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $title
 * @property string $link
 * @property string $image
 * @property ?float $was
 * @property float $for
 * @property ?float $installments
 * @property ?int $times
 * @property ?string $description
 * @property ?string $code
 * @property int $store_id
 * @property bool $is_top
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 * @property Category[] $categories
 * @property Store $store
 */
class Promotion extends Model
{
    /** @use HasFactory<PromotionFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'link',
        'image',
        'was',
        'for',
        'installments',
        'times',
        'code',
        'description',
        'store_id',
        'is_top',
    ];

    protected function casts(): array
    {
        return [
            'is_top' => 'boolean',
        ];
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class)->using(CategoryPromotion::class);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);

    }
}
