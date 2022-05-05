<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class Module extends Model
{
    use HasFactory, HasApiTokens;

    protected $guarded = ['module_id'];

    
    public function course(){
        return $this->belongsTo(course::class);
    }
}
