<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Estudiante extends Model
{
    public static function consultarEstudiantes()
    {
        try {
            // Intentar obtener datos de la base de datos
            $estudiantes = DB::table('users')->leftJoin('alumnos', 'users.id', 'alumnos.usuario_alumno')
                ->select(
                    'users.id',
                    'alumnos.nombre_alumno',
                    'alumnos.apellido_alumno',
                    'users.avatar_kid as personaje',
                    'users.pw_kid as password_emoji',
                    'alumnos.grado_alumno as grado',
                    'alumnos.grupo'
                )
                ->where('users.estado_usuario', 'ACTIVO')
                ->whereIn('alumnos.grado_alumno', [1, 2])
                ->get();
            
            return $estudiantes;
        } catch (\Exception $e) {
            // Si hay error en la base de datos, devolver array vacío
            Log::error('Error al consultar estudiantes: ' . $e->getMessage());
            return collect([]);
        }
    }
    public static function find($student_id)
    {
        return db::table('users')
            ->where('id', $student_id)
            ->first();
    }

    public static function obtenerPorGradoYGrupo($grado, $grupo)
    {
        return self::leftJoin('alumnos', 'users.id', '=', 'alumnos.usuario_alumno')
            ->where('users.estado_usuario', 'ACTIVO')
            ->where('alumnos.grado_alumno', $grado)
            ->where('alumnos.grupo', $grupo)
            ->select(
                'users.*',
                'alumnos.grado_alumno',
                'alumnos.grupo'
            )
            ->get();
    }
}
