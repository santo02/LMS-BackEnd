<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class course extends Model
{
    use HasFactory, HasApiTokens;

    protected $guarded = ['id'];

    public function course_id($id){
        return DB::table('courses')->where('id', $id)->get('id');
    }

    public function module(){
       return $this->hasMany(Module::class); 
    }

    public function students(){
        return $this->belongsToMany(Students::class, 'id');
    }
    
}
