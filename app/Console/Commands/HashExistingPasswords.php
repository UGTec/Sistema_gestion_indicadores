<?php

namespace App\Console\Commands;

use App\Models\Usuario;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class HashExistingPasswords extends Command
{
    protected $signature   = 'passwords:hash';
    protected $description = 'Permite "hashear" las contraseñas existentes en la base de datos';

    public function handle()
    {
        $usuarios = Usuario::whereNull('password')
        ->orWhere('password', 'NOT LIKE', '%$2y$%')
        ->get();

        foreach ($usuarios as $usuario) {
            if (!empty($usuario->password)) {
                $usuario->password = Hash::make($usuario->password);
                $usuario->save();
            }
        }

        $this->info("Contraseñas hasheadas correctamente para {$usuarios->count()} usuarios.");
    }
}
