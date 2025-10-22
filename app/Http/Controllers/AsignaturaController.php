<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Estudiante;
use Illuminate\Support\Facades\Auth;
use App\Models\Asignatura;
use Illuminate\Support\Facades\DB;

class AsignaturaController extends Controller
{
    public function detalleAsignatura($asignatura)
    { 
        try {

            //Validar usuario Auth
            if (!Auth::check()) {
                return redirect()->route('login');
            }
            
           
            // 1) Información base de la asignatura consultada
            $info = Asignatura::informacionAsignatura($asignatura); // se espera objeto/array con campos básicos
            
            // 2) Periodos desde base de datos
            $periodos = Asignatura::periodosAsignatura($asignatura);

            // 3) Armar estructura JSON solo para esta asignatura
            //    Estructura análoga a public/data/asignaturas.json
            $asignaturaJson = [
                'nombre' => $info->nombre ?? ($info['nombre'] ?? 'Asignatura'),
                'descripcion' => $info->presentacion_modulo ?? ($info['presentacion_modulo'] ?? null),
                'periodos' => []
            ];

            $pIdx = 1;
           
            foreach ($periodos as $periodo) {
                $pKey = 'periodo' . $pIdx;
                $asignaturaJson['periodos'][$pKey] = [
                    'nombre' => $periodo->des_periodo,
                    'unidades' => []
                ];

                $unidades = Asignatura::unidadesAsignatura($periodo->id);
                
                $uIdx = 1;
            
                foreach ($unidades as $unidad) {
                    $uKey = 'unidad' . $uIdx;
                    $asignaturaJson['periodos'][$pKey]['unidades'][$uKey] = [
                        'nombre' => $unidad->nom_unidad ?? null,
                        'descripcion' => $unidad->des_unidad ?? null,
                        'temas' => []
                    ];

     

                    $temas = Asignatura::temasAsignatura($unidad->id);
                  
                    $tIdx = 1;
                    foreach ($temas as $tema) {
                        $tKey = 'tema' . $tIdx;
                        $asignaturaJson['periodos'][$pKey]['unidades'][$uKey]['temas'][$tKey] = [
                            'nombre' => $tema->titu_contenido,
                            'id' => $tema->id,
                            'descripcion' => $tema->objetivo_general ?? null,
                            'descripcion_html' => $tema->contenido_tema ?? null,
                            'modelo_3d' => $tema->modelo_3d ?? null,
                            'evaluacion_inicio' => $tema->evaluacion_inicio ?? null,
                            'evaluacion_produccion' => $tema->evaluacion_produccion ?? null,
                            'video' => $tema->video ?? null,
                       
                        ];
                        $tIdx++;
                    }

                    $uIdx++;
                }

                $pIdx++;
            }
            // 4) Entregar la estructura al blade (el JS la consume con @json($asignatura))
            return view('asignatura', [
                'asignatura' => $asignaturaJson
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al cargar asignatura: ' . $e->getMessage());
            abort(500, 'Error al cargar la asignatura');
        }
    }

    public function listarAsignaturas($grado, $student_id)
    {


        //configurar autenticacion
        auth()->loginUsingId($student_id);

        //obtener datos del estudiante
        $estudiante = Estudiante::find($student_id);
        //obtener parametros de la url
        $parametros = DB::table('para_generales')
            ->first();

        session(['url_ped' => $parametros->url_ped]);
        session(['url_pedKids' => $parametros->url_ped_kid]);

        
        if ($estudiante) {
            //buscar asignaturas del estudiante
            $asignaturas = Asignatura::buscarAsignaturas($grado);
                
            return view('asignaturas', ['asignaturas' => $asignaturas] , ['grado' => $grado]);
        }
        else {
            abort(404, 'Estudiante no encontrado');
        }

    }
    
   
    
    private function getFallbackData()
    {
        return [
            'matematicas' => [
                'nombre' => 'Matemáticas',
                'descripcion' => 'Aprende números y operaciones de forma divertida',
                'icono' => '🔢',
                'color' => '#E74C3C',
                'periodos' => [
                    'periodo1' => [
                        'nombre' => 'Primer Período',
                        'descripcion' => 'Números básicos',
                        'unidades' => [
                            'unidad1' => [
                                'nombre' => 'Los Números',
                                'descripcion' => 'Aprende a contar',
                                'temas' => [
                                    'tema1' => [
                                        'nombre' => 'Números del 1 al 10',
                                        'descripcion' => 'Conoce los primeros números',
                                        'evaluacion_inicio' => true,
                                        'produccion' => true,
                                        'video' => [
                                            'titulo' => 'Contando Números',
                                            'duracion' => '5 minutos',
                                            'url' => '/videos/contando.mp4',
                                            'descripcion' => 'Aprende a contar del 1 al 10'
                                        ],
                                        'evaluacion' => [
                                            'titulo' => 'Juego de Números',
                                            'descripcion' => 'Practica contando',
                                            'url' => '/evaluacion/numeros'
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }
}
