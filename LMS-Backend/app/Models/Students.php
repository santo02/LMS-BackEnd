<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Students extends Model
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $guarded = ['id'];

    public function User(){
        return $this->belongsTo(\App\Models\User::class);
    }

    public function course()
    {
        return $this->belongsToMany(course::class, 'id');
    }
    
    
}
