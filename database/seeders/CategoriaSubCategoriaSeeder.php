<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;
use App\Models\SubCategoria;

class CategoriaSubCategoriaSeeder extends Seeder
{
    public function run()
    {
        // Lista de categorías con sus subcategorías
        //php artisan db:seed --class=CategoriaSubCategoriaSeeder

        $categorias = [
            [
                'nombre' => 'Computadoras y Laptops',
                'status' => 1,
                'subcategorias' => [
                    ['nombre' => 'Laptops', 'status' => 1],
                    ['nombre' => 'Computadoras de Escritorio', 'status' => 1],
                    ['nombre' => 'All-in-One', 'status' => 1],
                ],
            ],
            [
                'nombre' => 'Accesorios para Computadoras',
                'status' => 1,
                'subcategorias' => [
                    ['nombre' => 'Teclados', 'status' => 1],
                    ['nombre' => 'Ratones', 'status' => 1],
                    ['nombre' => 'Monitores', 'status' => 1],
                    ['nombre' => 'Webcams', 'status' => 1],
                ],
            ],
            [
                'nombre' => 'Componentes Internos',
                'status' => 1,
                'subcategorias' => [
                    ['nombre' => 'Procesadores', 'status' => 1],
                    ['nombre' => 'Tarjetas Madre', 'status' => 1],
                    ['nombre' => 'Memorias RAM', 'status' => 1],
                    ['nombre' => 'Discos Duros y SSD', 'status' => 1],
                    ['nombre' => 'Tarjetas Gráficas', 'status' => 1],
                ],
            ],
            [
                'nombre' => 'Redes y Conectividad',
                'status' => 1,
                'subcategorias' => [
                    ['nombre' => 'Routers', 'status' => 1],
                    ['nombre' => 'Switches', 'status' => 1],
                    ['nombre' => 'Adaptadores WiFi', 'status' => 1],
                    ['nombre' => 'Cables de Red', 'status' => 1],
                ],
            ],
            [
                'nombre' => 'Software y Licencias',
                'status' => 1,
                'subcategorias' => [
                    ['nombre' => 'Sistemas Operativos', 'status' => 1],
                    ['nombre' => 'Antivirus', 'status' => 1],
                    ['nombre' => 'Aplicaciones de Oficina', 'status' => 1],
                ],
            ],
        ];

        // Crear categorías y subcategorías
        foreach ($categorias as $categoriaData) {
            $categoria = Categoria::create([
                'nombre' => $categoriaData['nombre'],
                'status' => $categoriaData['status'],
            ]);

            foreach ($categoriaData['subcategorias'] as $subcategoriaData) {
                $categoria->subCategorias()->create($subcategoriaData);
            }
        }
    }
}
