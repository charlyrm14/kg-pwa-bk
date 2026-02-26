<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\{
    SwimProgram,
    SwimCategory,
    Skill
};

class SwimProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {

            $programs = $this->programData();

            foreach ($programs as $programData) {

                $program = SwimProgram::updateOrCreate(
                    ['name' => $programData['name']],
                    [
                        'min_age' => $programData['min_age'],
                        'max_age' => $programData['max_age'],
                        'is_sequential' => true,
                        'is_active' => true,
                    ]
                );

                foreach ($programData['categories'] as $index => $categoryData) {

                    $category = SwimCategory::updateOrCreate(
                        ['slug' => $categoryData['slug']],
                        [
                            'swim_program_id' => $program->id,
                            'name' => $categoryData['name'],
                            'description' => $categoryData['description'],
                            'level_order' => $index + 1,
                        ]
                    );

                    foreach ($categoryData['skills'] as $skillIndex => $skillDescription) {

                        Skill::updateOrCreate(
                            [
                                'swim_category_id' => $category->id,
                                'description' => $skillDescription,
                            ],
                            [
                                'skill_order' => $skillIndex + 1,
                            ]
                        );
                    }
                }
            }
        });
    }

    private function programData(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | BEBÉS (0–5)
            |--------------------------------------------------------------------------
            */
            [
                'name' => 'Bebés',
                'min_age' => 0,
                'max_age' => 5,
                'categories' => [
                    [
                        'name' => 'Pollito de Agua',
                        'slug' => 'pollito-de-agua',
                        'description' => '¡Tus primeros pasos en el agua! Empiezas a sentir confianza y a descubrir lo divertido que puede ser nadar.',
                        'skills' => [
                            'Adaptación básica al agua',
                            'Control de respiración inicial',
                            'Flotación asistida',
                        ],
                    ],
                    [
                        'name' => 'Pececillo',
                        'slug' => 'pececillo',
                        'description' => 'Ya te mueves con más seguridad. Comienzas a flotar y desplazarte con ayuda mínima.',
                        'skills' => [
                            'Flotación dorsal y ventral',
                            'Patada básica con apoyo',
                            'Inmersión corta controlada',
                        ],
                    ],
                    [
                        'name' => 'Patito',
                        'slug' => 'patito',
                        'description' => '¡Cada vez más independiente! Te desplazas pequeñas distancias sin miedo.',
                        'skills' => [
                            'Desplazamiento corto sin apoyo',
                            'Coordinación básica brazos-piernas',
                            'Entrada segura al agua',
                        ],
                    ],
                    [
                        'name' => 'Tortuguita',
                        'slug' => 'tortuguita',
                        'description' => 'Te mueves con calma y seguridad. Tu equilibrio y control mejoran en cada clase.',
                        'skills' => [
                            'Flotación prolongada',
                            'Patada constante sin asistencia',
                            'Control respiratorio rítmico',
                        ],
                    ],
                    [
                        'name' => 'Delfincito',
                        'slug' => 'delfincito',
                        'description' => '¡Listo para el siguiente nivel! Tu confianza y control te preparan para el programa infantil.',
                        'skills' => [
                            'Desplazamiento autónomo continuo',
                            'Coordinación básica de crol',
                            'Seguridad total en el agua',
                        ],
                    ],
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | NIÑOS (6–12)
            |--------------------------------------------------------------------------
            */
            [
                'name' => 'Niños',
                'min_age' => 6,
                'max_age' => 12,
                'categories' => [
                    [
                        'name' => 'Caballito de Mar',
                        'slug' => 'caballito-de-mar',
                        'description' => 'Aprendes técnica básica mientras ganas confianza y resistencia.',
                        'skills' => [
                            'Patada técnica de crol',
                            'Respiración lateral básica',
                            'Flotación sin asistencia',
                        ],
                    ],
                    [
                        'name' => 'Estrella de Mar',
                        'slug' => 'estrella-de-mar',
                        'description' => 'Tu coordinación mejora y comienzas a nadar distancias más largas.',
                        'skills' => [
                            'Coordinación completa en crol',
                            'Técnica básica de dorso',
                            'Giros simples en pared',
                        ],
                    ],
                    [
                        'name' => 'Delfín',
                        'slug' => 'delfin',
                        'description' => 'Tu técnica es cada vez más sólida. Ya dominas más de un estilo.',
                        'skills' => [
                            'Dominio de crol y dorso',
                            'Resistencia media',
                            'Salidas básicas desde borde',
                        ],
                    ],
                    [
                        'name' => 'Barracuda',
                        'slug' => 'barracuda',
                        'description' => 'Velocidad y técnica comienzan a combinarse. Tu control en el agua es notable.',
                        'skills' => [
                            'Técnica intermedia de pecho',
                            'Virajes básicos',
                            'Control de ritmo en distancia media',
                        ],
                    ],
                    [
                        'name' => 'Orca',
                        'slug' => 'orca',
                        'description' => 'Estás listo para entrenamiento avanzado. Tu técnica y resistencia destacan.',
                        'skills' => [
                            'Dominio de tres estilos',
                            'Virajes técnicos',
                            'Resistencia prolongada',
                        ],
                    ],
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | ADOLESCENTES (13–17)
            |--------------------------------------------------------------------------
            */
            [
                'name' => 'Adolescentes',
                'min_age' => 13,
                'max_age' => 17,
                'categories' => [
                    [
                        'name' => 'Tritón',
                        'slug' => 'triton',
                        'description' => 'Bases técnicas sólidas con enfoque en eficiencia.',
                        'skills' => [
                            'Técnica depurada de crol',
                            'Resistencia media-alta',
                            'Coordinación avanzada',
                        ],
                    ],
                    [
                        'name' => 'Marlin',
                        'slug' => 'marlin',
                        'description' => 'Tu potencia y técnica avanzan hacia un nivel competitivo.',
                        'skills' => [
                            'Técnica completa en tres estilos',
                            'Virajes rápidos',
                            'Control de tiempos',
                        ],
                    ],
                    [
                        'name' => 'Tiburón Azul',
                        'slug' => 'tiburon-azul',
                        'description' => 'Alto nivel técnico y resistencia sólida.',
                        'skills' => [
                            'Dominio de cuatro estilos',
                            'Salidas técnicas',
                            'Resistencia avanzada',
                        ],
                    ],
                    [
                        'name' => 'Leviatán',
                        'slug' => 'leviatan',
                        'description' => 'Nivel casi competitivo, con gran dominio del agua.',
                        'skills' => [
                            'Estrategia de competencia',
                            'Ritmo constante en largas distancias',
                            'Técnica refinada',
                        ],
                    ],
                    [
                        'name' => 'Poseidón',
                        'slug' => 'poseidon',
                        'description' => 'Máximo nivel juvenil. Técnica, potencia y resistencia en equilibrio.',
                        'skills' => [
                            'Dominio total de estilos',
                            'Preparación competitiva',
                            'Control físico y técnico completo',
                        ],
                    ],
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | ADULTOS (18+)
            |--------------------------------------------------------------------------
            */
            [
                'name' => 'Adultos',
                'min_age' => 18,
                'max_age' => 99,
                'categories' => [
                    [
                        'name' => 'Foca',
                        'slug' => 'foca',
                        'description' => 'Tu inicio en el mundo acuático. Aprendes confianza y técnica básica.',
                        'skills' => [
                            'Flotación básica',
                            'Patada inicial',
                            'Respiración controlada',
                        ],
                    ],
                    [
                        'name' => 'Tortuga',
                        'slug' => 'tortuga',
                        'description' => 'Te desplazas con mayor control y coordinación.',
                        'skills' => [
                            'Coordinación básica completa',
                            'Técnica inicial de crol',
                            'Resistencia corta',
                        ],
                    ],
                    [
                        'name' => 'Mantarraya',
                        'slug' => 'mantarraya',
                        'description' => 'Deslizamiento fluido y mayor dominio técnico.',
                        'skills' => [
                            'Técnica intermedia de crol',
                            'Técnica básica de dorso',
                            'Resistencia media',
                        ],
                    ],
                    [
                        'name' => 'Pez Vela',
                        'slug' => 'pez-vela',
                        'description' => 'Técnica avanzada y mayor velocidad en el agua.',
                        'skills' => [
                            'Dominio avanzado de crol',
                            'Virajes eficientes',
                            'Resistencia intermedia-alta',
                        ],
                    ],
                    [
                        'name' => 'Tiburón',
                        'slug' => 'tiburon',
                        'description' => 'Dominio total del agua. Velocidad, potencia y técnica avanzada.',
                        'skills' => [
                            'Dominio de múltiples estilos',
                            'Virajes técnicos',
                            'Alta resistencia',
                        ],
                    ],
                ],
            ],
        ];
    }
}
