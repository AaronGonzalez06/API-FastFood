<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Helpers\JwtAuth;

class UserController extends Controller
{
    public function addUser(Request $request){
        $json = $request->input('json',null);
        $param_array = json_decode($json,true);
        if(($param_array !=null)){
            $param_array = array_map('trim', $param_array);
            // validar datos
            $validate = \Validator::make($param_array, [
                'name'   => 'required|alpha_num',
                'email'   => 'required|email|unique:users,email',
                'password'   => 'required'
            ], [
                'name.required' => 'El campo nombre es obligatorio.',
                'name.alpha' => 'El campo nombre solo puede contener letras del alfabeto.',
                'email.required' => 'El campo email es obligatorio.',
                'email.email' => 'No es un email válido.',
                'email.unique' => 'El email ya esta registrado.',
                'password.required' => 'El campo fecha es obligatorio.'
            ]);

            if($validate->fails()){
                $data = array(
                    'status' => 'error',
                    'code' => 404,
                    'message' => 'User not added',
                    'errors' => $validate->errors()
                );

            }else{

                //crear usuario
                $user = new User();
                $user->name = $param_array['name'];
                $user->email = $param_array['email'];
                $user->password = bcrypt($param_array['password']);
                //guardar usuario
                $user->save();
                
                $data = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'User add',
                    'user' => $user
                );
            }
        }else{
            $data = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'User not added',
            );
        }
        return response()->json($data,$data['code']);
    }

    public function login(Request $request){
        $jwtAuth = new JwtAuth();

        $json = $request->input('json',null);
        $params = json_decode($json);
        $params_array = json_decode($json,true);

        $validate = \Validator::make($params_array, [
            'email'   => 'required|email',
            'password'   => 'required',
        ]);

        if($validate->fails()){
            $singnup = array(
                'status' => 'error',
                'code' => 404,
                'message' => 'Error login.',
                'errors' => $validate->errors(),
            );

        }else{
            $pwdSin = $params->password;
            if(empty($params->gettoken)){
                $singnup = $jwtAuth->signup($params->email, $pwdSin);
            }else{
                $singnup = $jwtAuth->signup($params->email, $pwdSin,true);
            }
        }
        return response()->json($singnup,200);
    }
}
