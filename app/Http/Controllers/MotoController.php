<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Moto;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MotosImporta;
use App\Exports\MotoExport;
use App\Exports\MotoExportRegistro;
class MotoController extends Controller

{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $busqueda = $request->input('busqueda', null);
        if(!$busqueda){
            $motos=Moto::where('idproceso','!=',5)->orderBy('created_at','desc')->get();
        } else{
            $motos=Moto::where('idproceso','!=',5)->where('modelo','like','%'.$busqueda.'%')->orderBy('created_at','desc')->get();
        }
        
        foreach($motos as $m){
            switch($m->idproceso){
                case 1:
                    $m->proceso= "INICIADO";
                    $m->colorestado = 'primary';
                break;
                case 2:
                    $m->proceso= "DETENIDO";
                    $m->colorestado = 'danger';
                break;
                case 3:
                    $m->proceso= "EMSAMBLADO";
                    $m->colorestado = 'info';
                break;
                case 4:
                    $m->proceso= "PROCESO DE CALIDAD";
                    $m->colorestado = 'warning';
                break;
                case 5:
                    $m->proceso= "TERMINADA";
                    $m->colorestado = 'success';
                break;
            }
        }
        return \response()->json([ 'status'=> 'correcto', 'motos'=>$motos],200);
    }
    public function inventario(Request $request){
        $fecha = $request->input('fecha', null);
        $motos=Moto::where([
            'idproceso'=> 5,
             ])->whereDate('updated_at',$fecha)->get();
        foreach($motos as $m){
            switch($m->idproceso){
                case 1:
                    $m->proceso= "INICIADO";
                    $m->colorestado = 'primary';
                break;
                case 2:
                    $m->proceso= "DETENIDO";
                    $m->colorestado = 'danger';
                break;
                case 3: 
                    $m->proceso= "EMSAMBLADO";
                    $m->colorestado = 'info';
                break;
                case 4:
                    $m->proceso= "PROCESO DE CALIDAD";
                    $m->colorestado = 'warning';
                break;
                case 5:
                    $m->proceso= "TERMINADA";
                    $m->colorestado = 'success';
                break;
            }
        }
        return \response()->json([ 'status'=> 'correcto', 'motos'=>$motos, 'fecha'=>$fecha],200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $json = $request->input('moto',null);
        $param_array= json_decode($json, true);
        
        $validate = \Validator::make($param_array,[
            'modelo' => 'required'
        ]);
        $moto = new Moto();
        $moto->modelo=($param_array['modelo']);
        $moto->chasis = ($param_array['chasis']);
        $moto->motor=($param_array['motor']);
        $moto->cilindraje=($param_array['cilindraje']);
        $moto->ref=($param_array['ref']);
        $moto->cpn=($param_array['cpn']);
        $moto->cn1=($param_array['cn1']);
        $moto->cn2=($param_array['cn2']);
        $moto->anio=($param_array['anio']);
        $moto->color1=($param_array['color1']);
        $moto->color2=($param_array['color2']);
        $moto->idproceso=($param_array['idproceso']);
        if($moto->save()){
            $respuesta = [
                'status' => "correcto",
                'moto' => $moto,
                'mensaje'=> 'Registro ingresado correctamente'
            ];
        }else{
            $respuesta = [
                'status' => "error",
                'mensaje'=> 'Error al guardar registro'
            ];
        }
        return \response()->json($respuesta,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $moto = Moto::find($id);
        return \response()->json([
            'status'=>'correcto',
            'moto'=>$moto
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $idproceso = $request->input('idproceso', null);
        $moto= Moto::find($id);
        $moto->idproceso = $idproceso;
        $moto->save();

        return \response()->json([
            'status'=>'correcto',
            'mensaje'=>'Proceso actualizado correctamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function search($texto){
        return \response()->json();
    }

    public function subirArchivo(Request $request){
       $file  = $request->file('archivo');
       Excel::import(new MotosImporta, $file);
        return \response()->json(['status'=>'correcto','mensaje'=>'Archivo subido correctamente'],200);
    }

    public function reporte(Request $request){
        $fecha = $request->input('fecha', null);
        return Excel::download( new MotoExport($fecha), 'reporte.xlsx');
    }

    public function reporteRegistro(){
        return Excel::download( new MotoExportRegistro(), 'reporte.xlsx');
    }
}
