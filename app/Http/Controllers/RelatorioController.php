<?php

namespace App\Http\Controllers;

use App\CaoFactura;
use App\CaoSalario;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RelatorioController extends Controller

 /*
    |--------------------------------------------------------------------------
    | Relatorio Controller
    |--------------------------------------------------------------------------
    |
    | Muestra Relatorio por cada consultor en tabla
    |
    |
    |
    */
{
    /**
     * Obtener Relatorio
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


                foreach ($request->data as $item) {
                    $cont = 0;
                    $salariob = CaoSalario::where('co_usuario', $item['id'])->get()->all();
                    $datosr = CaoFactura::receitaLiquida($item['id'],$from,$to);
                    $datosc = CaoFactura::comissao($item['id'],$from,$to);
                    empty($salariob)?$salario=0:$salario=$salariob[0]->brut_salario;
                    $datos = $datosr->merge($datosc)->groupBy('fecha');
                    $nombre = $item['text'];
                    foreach ($datos as $key => $value) {
                        $cont++;
                        $date = new Carbon($key);
                        $date = $date->format('m-Y');
                        $valor = $value->sum('valor');
                        $com = $value->sum('comision');
                        $lucro = $valor - ($salario + $com);
                        $lucro = number_format($lucro, 2, ',', '.');
                        $relatorio[$nombre][] = collect(['fecha' => $date, 'receital' => number_format($valor, 2, ',', '.'), 'comissao' => number_format($com, 2, ',', '.'), 'custo_fixo' => number_format($salario, 2, ',', '.'), 'lucro' => $lucro]);
                    }
                    $valor = $datosr->sum('valor');
                    $com = $datosc->sum('comision');
                    if (!empty($salariob)) {
                        $sal = ($salariob[0]->brut_salario) * $cont;} else {
                        $sal = 0;
                    }
                    $lucro = number_format($valor - ($sal + $com), 2, ',', '.');
                    $relatorio[$nombre]['saldo'] = collect(['receital_total' => number_format($valor, 2, ',', '.'), 'comissao_total' => number_format($com, 2, ',', '.'), 'custo_fixo_total' => number_format($sal, 2, ',', '.'), 'lucro_total' => $lucro]);

                }
                return response()->json(['relatorio' => $relatorio], 200);
            } catch (\Illuminate\Database\QueryException $ex) {
                \Log::error('Error al procesar la información: ' . $ex->getLine() . ' FILE: ' . $ex->getFile() . 'Message: ' . $ex->getMessage());
                return response()->json(['msg' => 'Error al procesar la información'], 500);
            }

        }

    }

}
