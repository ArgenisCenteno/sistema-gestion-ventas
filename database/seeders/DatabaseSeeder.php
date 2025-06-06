<?php
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Crear roles
        Role::create(['name' => 'superAdmin']);
        Role::create(['name' => 'empleado']);
        Role::create(['name' => 'cliente']);

        // Crear usuarios y asignar roles
        $superAdmin = User::create([
            'name' => 'Oscar Ibarra',
            'email' => 'oscaribarra@gmail.com',
            'password' => Hash::make('1234'),
        ]);
        $superAdmin->assignRole('superAdmin');

        $empleado = User::create([
            'name' => 'Salome',
            'email' => 'salome@gmai.com',
            'password' => Hash::make('1234'),
        ]);
        $empleado->assignRole('superAdmin');

        $cliente = User::create([
            'name' => 'Cliente',
            'email' => 'cliente@example.com',
            'password' => Hash::make('1234'),
        ]);
        $cliente->assignRole('cliente');
    }
}
