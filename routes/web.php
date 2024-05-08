<?php

use App\Livewire\Area\Index as AreaIndex;
use App\Livewire\Auth\Login;
use App\Livewire\Beneficio\Index as BeneficioIndex;
use App\Livewire\Empleado\Create as EmpleadoCreate;
use App\Livewire\Empleado\Edit as EmpleadoEdit;
use App\Livewire\Empleado\Index as EmpleadoIndex;
use App\Livewire\Empleado\Salario as EmpleadoSalario;
use App\Livewire\Home\Index as HomeIndex;
use App\Livewire\Modalidad\Index as ModalidadIndex;
use App\Livewire\Perfil\Index as PerfilIndex;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('/login', Login::class)
    ->middleware('guest')
    ->name('login');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', HomeIndex::class)
        ->name('home');

        
    Route::get('/perfil', PerfilIndex::class)
        ->name('perfil');

    Route::get('/empleados', EmpleadoIndex::class)
        ->name('empleados');
    Route::get('/empleados/{id_emp}/mod', EmpleadoEdit::class)
        ->name('empleados.editar');
    Route::get('/empleados/crear', EmpleadoCreate::class)
        ->name('empleados.crear');
    Route::get('/empleados/{id_emp}/salario', EmpleadoSalario::class)
        ->name('empleados.salario');

    Route::get('/beneficios', BeneficioIndex::class)
        ->name('beneficios');
    
    Route::get('/areas', AreaIndex::class)
        ->name('areas');
    
    Route::get('/modalidades', ModalidadIndex::class)
        ->name('modalidades');

});