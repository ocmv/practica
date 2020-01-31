<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class CaoFactura extends Model
{
    protected $table = 'cao_fatura';

    public function scopereceitaLiquida($query, $id,$from,$to)
    {
        return $query = DB::table('cao_fatura')
            ->join('cao_os', 'cao_fatura.co_os', '=', 'cao_os.co_os')
            ->select(DB::raw('DATE_FORMAT(cao_fatura.data_emissao,"%Y-%m") as fecha'), DB::raw('round(cao_fatura.valor - (cao_fatura.valor*(cao_fatura.total_imp_inc/100)),2) as valor'), 'cao_os.co_usuario')
            ->where('cao_os.co_usuario', '=', $id)
            ->whereRaw(' DATE_FORMAT(cao_fatura.data_emissao,"%Y-%m") between "'.$from.'" and "'.$to.'"')
            ->orderBy('fecha', 'ASC')
            ->get();
    }

    public function scopecomissao($query, $id,$from,$to)
    {
        return $query = DB::table('cao_fatura')
            ->join('cao_os', 'cao_fatura.co_os', '=', 'cao_os.co_os')
            ->select(DB::raw('DATE_FORMAT(cao_fatura.data_emissao,"%Y-%m") as fecha'), DB::raw('round((cao_fatura.valor - (cao_fatura.valor*(cao_fatura.total_imp_inc/100)))*(cao_fatura.comissao_cn/100),2) as comision'), 'cao_os.co_usuario')
            ->where('cao_os.co_usuario', '=', $id)
            ->whereRaw(' DATE_FORMAT(cao_fatura.data_emissao,"%Y-%m") between "'.$from.'" and "'.$to.'"')
            ->get();
    }

    public function scopetotalreceitaliquida($query,$id,$from,$to)
    {
        
        return $query = DB::table('cao_fatura')
            ->join('cao_os', 'cao_fatura.co_os', '=', 'cao_os.co_os')
            ->select(DB::raw('SUM(round(cao_fatura.valor - (cao_fatura.valor*(cao_fatura.total_imp_inc/100)),2)) as total'))
            ->whereRaw(' DATE_FORMAT(cao_fatura.data_emissao,"%Y-%m") between "'.$from.'" and "'.$to.'"')
            ->whereIn('cao_os.co_usuario', $id)
            ->get();
    }
}
