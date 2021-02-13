<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AuthController extends Controller
{
    function validar(Request $request){
        
        $usuario = $request->input('usuario',null);
        $password = $request->input('password',null);
        
        if($usuario && $password){
            $usuario = User::where(['usuario'=>$usuario,'password'=>md5($password)])->first();
            if($usuario){
                
                    if($usuario->rol==1){
                        $usuario->nombrerol = "Administrador";
                    }
                    if($usuario->rol==2){
                        $usuario->nombrerol = "Usuario";
                    }
                    if($usuario->rol==3){
                        $usuario->nombrerol = "Ensamblador";
                    }
                
                $respuesta = [
                    'status'=> 'correcto',
                    'usuario' => $usuario
                ];
            }else{
                $respuesta = [
                    'status'=> 'error',
                    'mensaje' => 'Credenciales incorrectas'
                ];
            }
           
        }else{
            $respuesta = [
                'status'=> 'error',
                // 'usuario'=>$usuario,
                // 'password'=>$password,
                'mensaje' => 'No se envio usuario o contraseña'
            ];
        }
        return \response()->json($respuesta,200);
    }
}
