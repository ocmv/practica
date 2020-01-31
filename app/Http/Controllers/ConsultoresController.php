<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CaoUsuario;

class ConsultoresController extends Controller
{
/*
    |--------------------------------------------------------------------------
    | Consultores Controller
    |--------------------------------------------------------------------------
    |
    | Muestra el total de consultores
    |
    |
    |
    */
    public function index(){

        $consultores = CaoUsuario::obtenerConsultores()->all();
        return view ('con_desempenho.index')->with(['consultores'=>$consultores]);

    }

}
