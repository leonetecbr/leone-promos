<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SentNotification extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['id', 'by', 'title', 'image', 'content', 'link', 'to'];
}
