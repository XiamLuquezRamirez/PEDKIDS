<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Asignatura extends Model
{
    use HasFactory;

    public static function buscarAsignaturas($grado)
    {
        $asignaturas = DB::table('modulos')
            ->join('asignaturas', 'modulos.asignatura', 'asignaturas.id')
            ->join('areas', 'asignaturas.area', 'areas.id')
            ->join('img_modulos', 'modulos.id', 'img_modulos.modulo_img')
            ->where('grado_modulo', $grado)
            ->where('estado_modulo', 'ACTIVO')
            ->select(
                'modulos.id',
                'asignaturas.nombre',
                'modulos.presentacion_modulo',
                'img_modulos.url_img',
                'areas.nombre_area'
            )
            ->get();

        return $asignaturas;
    }

    public static function informacionAsignatura($asignatura)
    {

        $asignaturaData = DB::table('modulos')
            ->join('asignaturas', 'modulos.asignatura', 'asignaturas.id')
            ->where('modulos.id', $asignatura)
            ->select('modulos.id', 'asignaturas.nombre', 'modulos.presentacion_modulo')
            ->first();

        return $asignaturaData;
    }

    public static function periodosAsignatura($asignatura)
    {
        $periodos = DB::table('periodos')
            ->where('modulo', $asignatura)
            ->select('periodos.id', 'periodos.des_periodo')
            ->where('estado', 'ACTIVO')
            ->get();
        return $periodos;
    }

    public static function unidadesAsignatura($periodo)
    {
        $unidades = DB::table('unidades')
            ->where('periodo', $periodo)
            ->select('id', 'nom_unidad', 'des_unidad')
            ->where('estado', 'ACTIVO')
            ->get();
        return $unidades;
    }

    public static function temasAsignatura($unidad)
    {
        $temas = DB::table('contenido')
            ->where('unidad', $unidad)
            ->where('estado', 'ACTIVO')
            ->select(
                'id',
                'tip_contenido',
                'hab_cont_didact',
                'titu_contenido',
                'objetivo_general',
                'habilitado',
                'docente',
                'docente_propietario',
                'modelo_3d'
            )
            ->get();

        foreach ($temas as $tema) {

            if ($tema->tip_contenido == 'DOCUMENTO') {
                $tema->contenido_tema = DB::table('cont_documento')
                    ->where('contenido', $tema->id)
                    ->select('id', 'titulo', 'cont_documento')
                    ->first();
            } else if ($tema->tip_contenido == 'ARCHIVO') {
                $tema->contenido_tema = DB::table('cont_archivos')
                    ->where('contenido', $tema->id)
                    ->select('id', 'titulo', 'nom_arch')
                    ->first();
            } else if ($tema->tip_contenido == 'CONTENIDO DIDACTICO') {
                $tema->contenido_tema = DB::table('cont_didactico')
                    ->where('contenido', $tema->id)
                    ->select('id', 'titulo', 'cont_didactico')
                    ->first();
            } else if ($tema->tip_contenido == 'LINK') {
                $tema->contenido_tema = DB::table('cont_link')
                    ->where('contenido', $tema->id)
                    ->select('id', 'titulo', 'url')
                    ->first();
            }
          

            $tema->video = DB::table('cont_didactico')
                ->where('contenido', $tema->id)
                ->select('id', 'titulo', 'cont_didactico')
                ->get();
          

            $tema->evaluacion_produccion = DB::table('evaluacion')
                ->where('contenido', $tema->id)
                ->where('clasificacion', 'PRODUC')
                ->where('estado', 'ACTIVO')
                ->select(
                    'id',
                    'titulo',
                    'intentos_perm',
                    'calif_usando',
                    'punt_max',
                    'intentos_real',
                    'tiempo',
                    'hab_tiempo'
                )
                ->get();
               
            $tema->evaluacion_inicio = DB::table('evaluacion')
                ->where('contenido', $tema->id)
                ->where('clasificacion', 'ACTINI')
                ->where('estado', 'ACTIVO')
                ->select(
                    'id',
                    'titulo',
                    'intentos_perm',
                    'calif_usando',
                    'punt_max',
                    'intentos_real',
                    'tiempo',
                    'hab_tiempo'
                )
                ->get();
        }



        return $temas;
    }
}
