<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class CaoUsuario extends Model
{

    public function scopeobtenerConsultores($query)
    {
        return $query = DB::table('cao_usuario')
            ->join('permissao_sistema', 'cao_usuario.co_usuario', '=', 'permissao_sistema.co_usuario')
            ->select('cao_usuario.no_usuario', 'cao_usuario.co_usuario')
            ->where([
                ['permissao_sistema.co_sistema', '=', '1'],
                ['permissao_sistema.in_ativo', '=', 's'],
            ])
            ->whereIn('co_tipo_usuario', [0, 1, 2])
            ->get();
    }
}
