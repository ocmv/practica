<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CaoFactura;
use Carbon\Carbon;

class PizzaController extends Controller
{
/*
    |--------------------------------------------------------------------------
    | Pizza Controller
    |--------------------------------------------------------------------------
    |
    | Muestrap orcentaje de receita líquida  por cada consultor en Gráfica de Pizza
    |
    |
    |
    */

    public function index(Request $request){
        if ($request->wantsJson()) {

            try {
                $from=$request->fecha[0];
                $to=$request->fecha[1];
                $fromv=Carbon::createFromFormat('Y-m',$from);
                $tov=Carbon::createFromFormat('Y-m',$to);

                if($fromv->gt($tov)){
                    $fecha=collect(['fecha'=>'Esta fecha debe ser menor']);
                    return response()->json(['errors' => $fecha], 422);
                }

                    $this->validate($request,[
                        'data' => 'required',
                        ],$messages = [
                            'required' => 'Debe seleccionar al menos un Consultor.',
                    ]);
        $ids = array_column($request->data, 'id');


        $total = CaoFactura::totalreceitaliquida($ids,$from,$to);
        foreach ($request->data as $item) {
        $nombre = $item['text'];
        $data = CaoFactura::receitaLiquida($item['id'],$from,$to);

        $totalU=$data->sum('valor');
        $porcentaje = ($totalU*100)/$total[0]->total;
        $receita[$nombre][] = collect(['porcentaje' => $porcentaje]);
        }
        return response()->json(['receita' => $receita,'total'=>$total[0]->total], 200);

    } catch (\Illuminate\Database\QueryException $ex) {
        \Log::error('Error al procesar la información: ' . $ex->getLine() . ' FILE: ' . $ex->getFile() . 'Message: ' . $ex->getMessage());
        return response()->json(['msg' => 'Error al procesar la información'], 500);
    }
}
    }
}
