<?php

namespace App\Http\Controllers;

use App\CaoFactura;
use App\CaoSalario;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class ColumnasController extends Controller


{

    /*
    |--------------------------------------------------------------------------
    | Colummnas Controller
    |--------------------------------------------------------------------------
    |
    | Muestra en Colummnas el desempeño por cada consultor
    |
    |
    |
    */
    public function index(Request $request)
    {
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

                $period = CarbonPeriod::create($from, '1 month', $to);
                foreach ($period as $dt) {
                    $x[] = $dt->format("m-Y");
                }
                $ids = array_column($request->data, 'id');
                $cant = count($ids);

                $prom = CaoSalario::customf($ids, $cant)->all();
                foreach ($request->data as $item) {
                    $datosr = CaoFactura::receitaLiquida($item['id'],$from,$to)->groupBy('fecha');
                    $nombre = $item['text'];
                    if ($datosr->isNotEmpty()) {
                        foreach ($datosr as $key => $value) {
                            $date = new Carbon($key);
                            $date = $date->format('m-Y');
                            $record[] = $date;
                            $valor = $value->sum('valor');
                            $columna[$nombre][] = collect(['fecha' => $date, 'receita' => $valor]);
                        }} else {
                        $record = [];
                    }
                    $nr = array_diff($x, $record);

                    if (!empty($nr)) {

                        $nr = collect([$nr]);
                        $nr = $nr->flatten();
                        $format = $nr->map(function ($item, $key) {
                            return collect(['fecha' => $item, 'receita' => 0]);
                        });
                        foreach ($format as $key => $value) {
                            $columna[$nombre][] = $value;
                        }
                    }
                }
                return response()->json(['columna' => $columna, 'ejeX' => $x, 'prom' => $prom[0]->promedio], 200);
            } catch (\Illuminate\Database\QueryException $ex) {
                \Log::error('Error al procesar la información: ' . $ex->getLine() . ' FILE: ' . $ex->getFile() . 'Message: ' . $ex->getMessage());
                return response()->json(['msg' => 'Error al procesar la información'], 500);
            }
        }
    }
}
