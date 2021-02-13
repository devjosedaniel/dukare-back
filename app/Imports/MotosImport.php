<?php

namespace App\Imports;

use App\Moto;
use Maatwebsite\Excel\Concerns\ToModel;

class MotosImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Moto([
           'ref' => $row[0],
           'modelo' => $row[1],
           'cpn' => $row[2],
           'cn1' => $row[3],
           'cilindraje' => $row[4],
           'chasis' => $row[5],
           'cn2' => $row[6],
           'motor' => $row[7],
           'color1' => $row[8],
           'color2' => $row[9],
           'anio' => $row[10],
           'idproceso' => 1,
        ]);
    }
}
