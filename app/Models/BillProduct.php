<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillProduct extends Model
{
    use HasFactory;

    protected $table = 'bill_product';

    protected $fillable = [
        'id',
        'bill_id',
        'product_id',
    ];

    public function product(){
        return $this->belongsTo('App\Models\Product','product_id');
    }
}
