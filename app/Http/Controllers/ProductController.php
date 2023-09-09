<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Product;

class ProductController extends Controller
{
    public function list(){
        $products = Product::get();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'totalProduct' => $products->count(),
            'products' => $products
        ]);
    }

    public function listProductSection($id){

        $products = Product::where('section_id', $id)
                            ->with('section')
                            ->get();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'totalProduct' => $products->count(),
            'products' => $products
        ]);

    }

    public function listPrice($priceOne,$priceTwo){
        $products = Product::whereBetween('price', [$priceOne, $priceTwo])->with('section')->get();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'totalProduct' => $products->count(),
            'products' => $products
        ]);
    }
}
