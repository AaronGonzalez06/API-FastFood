<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $table = 'bills';

    protected $fillable = [
        'id',
        'date',
        'user_id'
    ];

    //prueba n:m
    public function products(){
        return $this->belongsToMany('App\Models\Product');
    }

}
