<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = ["name", "email", "password"];
    
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
}
