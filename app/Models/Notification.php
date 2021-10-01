<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model{
  public $timestamps = false;
  protected $primaryKey = 'user_id';
  
  use HasFactory;
}
