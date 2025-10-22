<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{

    public static function consultarEstudiantes()
    {
        return self::leftJoin('alumnos', 'users.id', '=', 'alumnos.usuario_alumno')
        ->where('users.activo', true)
        ->whereIn('alumnos.grado', [1, 2])
        ->select('users.*', 'alumnos.grado', 'alumnos.grupo')
        ->get();
    }
}
