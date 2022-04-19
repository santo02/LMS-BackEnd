<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Theacers extends Model
{
    use HasFactory, HasApiTokens;
    protected $guarded = ['id'];

    public function User(){
        return $this->belongsTo(\App\Models\User::class);
    }
}
