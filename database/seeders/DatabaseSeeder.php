<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        if (! Usuario::where('acceso', 'admin')->exists()) {
            Usuario::create([
                'nombre' => 'Administrador',
                'apellidos' => 'Sistema',
                'acceso' => 'admin',
                'secreto' => 'admin123',
                'estado' => 1,
            ]);
        }
    }
}
