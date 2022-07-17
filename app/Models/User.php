<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Cria os registros padrões no banco de dados
     * @return void
     */
    public static function initialize()
    {
        self::create([
            'name' => 'Admin',
            'email' => 'admin@' . env('APP_DOMAIN'),
            'email_verified_at' => time(),
            'password' => password_hash(env('APP_PASSWORD'), PASSWORD_DEFAULT),
            'remember_token' => bin2hex(openssl_random_pseudo_bytes(32))
        ]);
    }
}
