<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SourceCode extends Model
{
    use HasFactory;

    protected $fillable = ["user_id", "title", "code"];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
