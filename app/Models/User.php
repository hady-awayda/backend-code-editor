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
        return $this->hasMany(Conversation::class);
    }

    public function sourceCodes()
    {
        return $this->hasMany(SourceCode::class);
    }
}
