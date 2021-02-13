<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Moto extends Model
{
    protected $table = "motos";
    protected $fillable = ['ref','modelo','chasis','motor','cilindraje','idproceso',
                            'cpn', 'cn1','cn2', 'anio', 'color1' , 'color2'
                            ];
}
