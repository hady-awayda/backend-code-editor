<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = ["name", "email", "password", "role"];
    
    public function conversations()
    {
        return $this->hasMany(Conversation::class, 'user_id_1')->orWhere('user_id_2', $this->id);
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }
    
    public function sourceCodes()
    {
        return $this->hasMany(SourceCode::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    
    public function getJWTCustomClaims()
    {
        return [
            "user_id" => $this->id,
            "name" => $this->name,
            "role" => $this->role
        ];
    }
}
