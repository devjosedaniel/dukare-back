<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class UsuarioController extends Controller
{
    public function index(){
        $usuarios = User::where('estado',1)->get();
        foreach($usuarios as $u){
            if($u->rol==1){
                $u->nombrerol = "Administrador";
            }
            if($u->rol==2){
                $u->nombrerol = "Usuario";
            }
            if($u->rol==3){
                $u->nombrerol = "Ensamblador";
            }

        }
        $respuesta = [
            'status'=>'correcto',
            'usuarios'=> $usuarios
        ];
        return \response()->json($respuesta,200);
    }

    public function store(Request $request){
        $usuario = $request->input('usuario',null);
        $password = $request->input('password',null);
        $rol = $request->input('rol',null);
        
        $validar = User::where('usuario',$usuario)->first();
        if($validar){
            $respuesta = [
                'status'=>'error',
                'mensaje'=>'Nombre de usuario ya existe'
            ];
        }else{
            $u = new User();
            $u->usuario = $usuario;
            $u->password = md5($password);
            $u->rol = $rol;

            $u->save();
            $respuesta = [
            'status'=>'correcto',
            'mensaje'=>'Usuario agregado correctamente'
            ];
        }
        
        return \response()->json($respuesta,200);
    }



    public function destroy($id){
        $usuario = User::find($id);
        $usuario->estado = 0;
        $usuario->save();
        $respuesta = [
            'status'=>'correcto',
            'mensaje'=>'Usuario eliminado correctamente'
        ];
        return \response()->json($respuesta,200);
    }

    public function show($id){
        $usuario = User::find($id);
        $respuesta = [
            'status'=>'correcto',
            'usuario'=>$usuario
        ];
        return \response()->json($respuesta,200);
    }

    public function update($id, Request $request) {
        $usuario = $request->input('usuario',null);
        $password = $request->input('password',null);
        $rol = $request->input('rol',null);
        
        $u = User::find($id);
        if(isset($password) && $password!='undefined') {
            $u->usuario = $usuario;
            $u->password = md5($password);
            $u->rol = $rol;
            $u->save();
            $respuesta = [
                'status'=>'correcto',
                'cod'=>'se envio password',
                'pass'=>$password,
                'mensaje'=>'Usuario actualizado correctamente'
            ];
        }else{
            $u->usuario = $usuario;
            $u->password = $u->password;
            $u->rol = $rol;
            $u->save();
            $respuesta = [
                'status'=>'correcto',
                'cod'=>'no se envio password',
                'pass'=>$password,
                'mensaje'=>'Usuario actualizado correctamente'
            ];
        }
        
        return \response()->json($respuesta,200);
    }
}
