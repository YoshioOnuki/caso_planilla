<?php

namespace App\Livewire\Pago;

use App\Models\Empleado;
use App\Models\Pago;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    #[Url('mostrar')]
    public $mostrar_paginate = 10;

    public function generar_pagos2()
    {
        $empleados = Empleado::where('estado_emp', 1)->get();
        $fecha_actual = date('Y-m-d');

        try {
            DB::beginTransaction();
            foreach ($empleados as $empleado) {
                $fecha_ingreso = $empleado->fecha_ingreso_emp;

                $diferencia = strtotime($fecha_actual) - strtotime($fecha_ingreso);
                $meses = floor($diferencia / (60 * 60 * 24 * 30));

                if ($meses > 0) {
                    for ($i = 0; $i <= $meses; $i++) {
                        $fecha_pago = date('Y-m-t', strtotime($fecha_ingreso . ' + ' . $i . ' month'));
                        $pago = Pago::firstOrCreate(
                            ['id_emp' => $empleado->id_emp, 'fecha_pago' => $fecha_pago],
                            [
                                'monto_pago' => $empleado->salario_emp,
                                'id_area' => $empleado->id_area,
                                'id_historial' => $empleado->historialSalario->where('estado_historial', 1)->first()->id_historial
                            ]
                        );
                    }
                }
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }
    }

    public function generar_pagos3()
    {
        $empleados = Empleado::where('estado_emp', 1)->get();
        $fecha_actual = date('Y-m-d');

        try {
            DB::beginTransaction();
            foreach ($empleados as $empleado) {
                $fecha_ingreso = $empleado->fecha_ingreso_emp;

                $diferencia = strtotime($fecha_actual) - strtotime($fecha_ingreso);
                $meses = floor($diferencia / (60 * 60 * 24 * 30));

                if ($meses >= 0) {
                    for ($i = 0; $i <= $meses; $i++) {
                        $fecha_pago = date('Y-m-t', strtotime($fecha_ingreso . ' + ' . $i . ' month'));

                        // Si el mes de la fecha de pago es el mes actual, continuar con la siguiente iteración
                        if (date('m', strtotime($fecha_pago)) == date('m')) {
                            continue;
                        }

                        $pago = Pago::firstOrCreate(
                            ['id_emp' => $empleado->id_emp, 'fecha_pago' => $fecha_pago],
                            [
                                'monto_pago' => $empleado->salario_emp,
                                'id_area' => $empleado->id_area,
                                'id_historial' => $empleado->historialSalario->where('estado_historial', 1)->first()->id_historial
                            ]
                        );
                    }
                }
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }
    }

    public function mount()
    {
        $this->generar_pagos3();
    }

    public function render()
    {
        $pagos = Pago::with('empleado', 'area', 'historialSalario')
            ->orderBy('fecha_pago', 'desc')
            ->paginate($this->mostrar_paginate);

        return view('livewire.pago.index', [
            'pagos' => $pagos,
        ]);
    }
}
