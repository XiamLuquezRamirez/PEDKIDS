<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudiante;
use Illuminate\Support\Facades\Log;

class EstudiantesController extends Controller
{
    public function listarEstudiantes()
    {
       
        try {
            $estudiantes = Estudiante::consultarEstudiantes();        
            
            // Si no hay estudiantes en la BD, usar datos de fallback
            if ($estudiantes->isEmpty()) {
                return response()->json($this->getFallbackData());
            }
            
            // Formatear datos para que coincidan con la estructura esperada por el frontend
            $dataFormateada = [
                'grados' => []
            ];
            
            // Agrupar estudiantes por grado y grupo
            foreach ($estudiantes as $estudiante) {
                $grado = $estudiante->grado ?? '1';
                $grupo = $estudiante->grupo ?? '1';
                
                if (!isset($dataFormateada['grados'][$grado])) {
                    $dataFormateada['grados'][$grado] = [
                        'grupos' => []
                    ];
                }
                
                if (!isset($dataFormateada['grados'][$grado]['grupos'][$grupo])) {
                    $dataFormateada['grados'][$grado]['grupos'][$grupo] = [
                        'nombre' => "Grupo {$grupo}",
                        'estudiantes' => []
                    ];
                }
                
                $estudianteData = [
                    'id' => $estudiante->id,
                    'nombre' => $estudiante->nombre_alumno,
                    'apellido' => $estudiante->apellido_alumno
                ];
                
                // Agregar campos según el tipo de autenticación
                // Grados 1-2: autenticación con emojis
                $personaje = $estudiante->personaje ?? '🐸';
                $estudianteData['personaje'] = $personaje;
                
                // Determinar nombre del personaje basado en el emoji
                $personajesNombres = [
                    '🐸' => 'rana',
                    '🐱' => 'gato',
                    '🐰' => 'conejo',
                    '🐻' => 'oso',
                    '🐶' => 'perro',
                    '🐼' => 'panda',
                    '🦁' => 'león',
                    '🐯' => 'tigre',
                    '🦊' => 'zorro',
                    '🐨' => 'koala'
                ];
                
                $estudianteData['personaje_nombre'] = $personajesNombres[$personaje] ?? 'amigo';
                $estudianteData['password_emoji'] = is_string($estudiante->password_emoji) 
                    ? json_decode($estudiante->password_emoji, true) 
                    : ($estudiante->password_emoji ?? ["estrella", "corazon", "sol"]);
                
                $dataFormateada['grados'][$grado]['grupos'][$grupo]['estudiantes'][] = $estudianteData;
            }
            
            return response()->json($dataFormateada);
            
        } catch (\Exception $e) {
            // En caso de error, devolver datos de fallback
            Log::error('Error al consultar estudiantes: ' . $e->getMessage());
            return response()->json($this->getFallbackData());
        }
    }
    
    private function getFallbackData()
    {
        return [
            'grados' => [
                "1" => [
                    'grupos' => [
                        "A" => [
                            'nombre' => "Grupo A",
                            'estudiantes' => [
                                [
                                    'id' => 1,
                                    'nombre' => "Ana",
                                    'apellido' => "García",
                                    'personaje' => "🐸",
                                    'personaje_nombre' => "rana",
                                    'password_emoji' => ["⭐", "❤️", "☀️"],
                                    'activo' => true
                                ],
                                [
                                    'id' => 2,
                                    'nombre' => "Carlos",
                                    'apellido' => "López",
                                    'personaje' => "🐱",
                                    'personaje_nombre' => "gato",
                                    'password_emoji' => ["🌙", "🌈", "🌸"],
                                    'activo' => true
                                ]
                            ]
                        ],
                        "B" => [
                            'nombre' => "Grupo B",
                            'estudiantes' => [
                                [
                                    'id' => 3,
                                    'nombre' => "María",
                                    'apellido' => "Rodríguez",
                                    'personaje' => "🐰",
                                    'personaje_nombre' => "conejo",
                                    'password_emoji' => ["⭐", "🌙", "❤️"],
                                    'activo' => true
                                ]
                            ]
                        ]
                    ]
                ],
                "2" => [
                    'grupos' => [
                        "A" => [
                            'nombre' => "Grupo A",
                            'estudiantes' => [
                                [
                                    'id' => 4,
                                    'nombre' => "Diego",
                                    'apellido' => "Martínez",
                                    'personaje' => "🐻",
                                    'personaje_nombre' => "oso",
                                    'password_emoji' => ["🌈", "☀️", "🌸"],
                                    'activo' => true
                                ]
                            ]
                        ]
                    ]
                ],
                "3" => [
                    'grupos' => [
                        "A" => [
                            'nombre' => "Grupo A",
                            'estudiantes' => [
                                [
                                    'id' => 5,
                                    'nombre' => "Sofía",
                                    'apellido' => "Hernández",
                                    'usuario' => "sofia.hernandez",
                                    'password' => "sofia123",
                                    'activo' => true
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }
}