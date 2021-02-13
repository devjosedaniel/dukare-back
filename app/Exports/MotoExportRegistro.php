<?php

namespace App\Exports;

use App\Moto;
use Maatwebsite\Excel\Concerns\FromCollection;

class MotoExportRegistro implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Moto::where('idproceso','!=',5)->orderBy('created_at','desc')->get();
    }
}
