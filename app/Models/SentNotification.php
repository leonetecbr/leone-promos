<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $title
 * @property string $image
 * @property string $content
 * @property string $link
 * @property int $clicks
 * @property int $sent_by
 * @property ?Carbon $sent_at
 * @property User $sentBy
 */
class SentNotification extends Model
{
    use HasFactory;

    const string CREATED_AT = 'sent_at';
    const null UPDATED_AT = null;

    public function sentBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
