<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class JwtAuth{

    public $key;

    public function __construct(){
        $this->key = "clave_secreta_aaron";
    }

    public function signup($email,$password, $getToken = null){
        $user = User::where([
            'email' => $email
        ])->first();

        $signup= false;
        if(is_object($user) && Hash::check($password, $user->password)){
            $signup = true;
        }

        if($signup){
            $token = array(
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password,
                'iat' => time(),
                'exp' => time() + (7 * 24 * 24 * 60 * 60)
            );

            $jwt = JWT::encode($token,$this->key,'HS256');
            if(is_null($getToken)){
                $data = $jwt;
            }else{
                $decoded = JWT::decode($jwt, new Key($this->key, 'HS256'));
                $data = $decoded;
            }

        }else {
            $data = array(
                'status' => 'error',
                'message' => 'Login incorrecto'
            );
        }

        return $data;
    }

    public function checkToken($jwt,$getIdentity = false){
        $auth = false;

        try{
            $jwt = str_replace('"','', $jwt);
            $decoded = JWT::decode($jwt, new Key($this->key, 'HS256'));
        }catch(\UnexpectedValueException $e){
            $auth = false;
        }catch(\DomainException $e){
            $auth = false;
        }

        if(!empty($decoded) && is_object($decoded) && isset($decoded->id)){
            $auth = true;
        }else{
            $auth = false;
        }

        if($getIdentity){
            return $decoded;
        }
        
        return $auth;
    }

}