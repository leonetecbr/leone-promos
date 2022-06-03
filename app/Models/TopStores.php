<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopStores extends Model
{
    use HasFactory;
    protected $table = 'top_stores';
    protected $fillable = ['id', 'name', 'title', 'image', 'url'];
    public $timestamps = false;
}
