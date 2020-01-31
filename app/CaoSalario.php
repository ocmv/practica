<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class CaoSalario extends Model
{

    protected $table = 'cao_salario';

    public function scopecustomf($query, $id, $cant)
    {
        return $query = DB::table('cao_salario')
            ->join('cao_usuario', 'cao_salario.co_usuario', '=', 'cao_usuario.co_usuario')
            ->select(DB::raw('sum(cao_salario.brut_salario)/' . $cant . ' as promedio'))
            ->whereIn('cao_salario.co_usuario', $id)
            ->get();

    }

}
