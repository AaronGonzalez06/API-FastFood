<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Models\Bill;
use App\Models\BillProduct;
use App\Models\Product;
use App\Helpers\JwtAuth;
use Carbon\Carbon;

class BillController extends Controller
{

    public function bills($id){

        $bills = Bill::where('user_id',$id)->with('products')->get();
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'totalBill' => $bills[0]['products']->count(),
            'bills' => $bills
        ]);
    }


    /** Facturacion */

    public function addBill(Request $request){
        $token = $request->header("Authorization");
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token,true);        
        $datetime = Carbon::now()->format('Y-m-d H:i:s');

        $bill = new Bill();
        $bill->date = $datetime;
        $bill->user_id = $checkToken->id;
        $bill->save();

        $data = array(
            'status' => 'success',
            'code' => 200,
            'message' => 'Compra realizada,espere sus productos',
        );
        return response()->json($data,$data['code']);
    }

    public function addProductBill(Request $request){
        $json = $request->input('json',null);
        $param_array = json_decode($json,true);
        if(($param_array !=null)){
            $param_array = array_map('trim', $param_array);
                //crear usuario
                $billProduct = new BillProduct();
                $billProduct->bill_id = $param_array['billId'];
                $billProduct->product_id = $param_array['productId'];
                $billProduct->save();
                $billProduct->product;
                $data = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'billProduct add',
                    'billProduct' => $billProduct
                );
        }else{
            $data = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Error',
            );
        }
        return response()->json($data,$data['code']);
    }
}
