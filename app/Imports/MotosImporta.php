<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Moto;
class MotosImporta implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
       $cont=1;
       foreach($collection as $c){
           if($cont != 1){
           
            $moto = new Moto();
            $moto->modelo=$c[1];
            $moto->chasis = $c[5];
            $moto->motor=$c[7];
            $moto->cilindraje=$c[4];
            $moto->ref= $c[0];
            $moto->cpn=$c[2];
            $moto->cn1=$c[3];
            $moto->cn2=$c[6];
            $moto->color1=$c[8];
            $moto->color2=$c[9];
            $moto->anio = $c[10];
            $moto->idproceso=1;
            $moto->save();
           }
           $cont++;
       }
    }
}
