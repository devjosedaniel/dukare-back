<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modelo;
class ModeloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $modelos = Modelo::all();
        $modelos = Modelo::where('estado',1)->orderBy('nombre')->get();
        // $modelos = Modelo::all()->where('estado',1);
        return \response()->json([
            'status'=>"correcto",
            'modelos'=>$modelos
        ],200);
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
        $modelo = $request->input('modelo', null);
        $m = new Modelo();
        $m->nombre = $modelo;
        $m->save();
        $respuesta = [
            'status' => 'correcto',
            'mensaje'=>'Modelo agregado correctamente',
            'modelo'=>$modelo
        ];
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $modelo = Modelo::find($id);
        $modelo->estado=0;
        $modelo->save();
        $respuesta = [
            'status' => 'correcto',
            'mensaje'=> 'Modelo eliminado correctamente'
        ];
        return \response()->json($respuesta,200);
    }
}
