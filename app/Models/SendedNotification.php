<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendedNotification extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'sended_notifications';
    protected $fillable = ['id', 'by', 'title', 'image', 'content', 'link', 'to'];
}
