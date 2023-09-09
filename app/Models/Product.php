<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'id',
        'name',
        'description',
        'price',
        'amount',
        'image',
        'section_id',
    ];

    public function section(){
        return $this->belongsTo('App\Models\Section','section_id');
    }

    //prueba N:M
    public function bills(){
        return $this->belongsToMany('App\Models\Bill');
    }
}
