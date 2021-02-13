<?php

namespace App\Exports;

use App\Moto;
use Maatwebsite\Excel\Concerns\FromCollection;

class MotoExport implements FromCollection
{
    private $fecha;
    function __construct($fecha) {
        $this->fecha = $fecha;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Moto::where([
            'idproceso'=> 5,
             ])->whereDate('updated_at',$this->fecha)->get();
    }
}
