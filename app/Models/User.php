<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property integer $id
 * @property string $name
 * @property null|string $image
 * @property string $username
 * @property string $email
 * @property null|string $email_verified_at
 * @property string $password
 * @property array $privileges
 * @property null|integer $google_id
 * @property null|integer $facebook_id
 * @property string $created_at
 * @property string $updated_at
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'privileges' => 'array',
        'image' => 'boolean',
    ];

    /**
     * Verifica se o usuário é um administrador
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return in_array('administrator', $this->privileges);
    }

    /**
     * Retorna a URL da imagem do usuário
     *
     * @return string
     */
    public function getAvatar(): string
    {
        return $this->image ? "/img/users/$this->id.jpg" : '/img/users/default.jpg';
    }

    /**
     * Retorna a data de criação da conta
     *
     * @return string
     */
    public function getCreateDate(): string
    {
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        return strftime('%d de %B de %Y', strtotime($this->created_at));
    }
}
