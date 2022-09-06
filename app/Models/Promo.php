<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'id',
        'group_id',
        'store_id',
        'name',
        'link',
        'image',
        'from',
        'for',
        'times',
        'installments',
        'page'
    ];
}
