<?php

namespace App\Livewire\Empleado;

use App\Models\Area;
use App\Models\Beneficio;
use App\Models\Empleado;
use App\Models\HistorialSalario;
use App\Models\Modalidad;
use App\Models\Persona;
use DateTime;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Create extends Component
{
    #[Validate('required')]
    public $nombre;
    #[Validate('required')]
    public $apellido_paterno;
    #[Validate('required')]
    public $apellido_materno;
    #[Validate('required')]
    public $documento;
    #[Validate('required')]
    public $fecha_nacimiento;
    #[Validate('required')]
    public $genero;
    #[Validate('required')]
    public $salario;
    #[Validate('required')]
    public $fecha_ingreso;
    #[Validate('required')]
    public $fecha_egreso;
    #[Validate('required')]
    public $jornada_laboral;
    #[Validate('required')]
    public $area;
    #[Validate('required')]
    public $modalidad;

    public $existe = false;

    //Funcion update, si la modalidad es 'Plazo Indeterminado' la fecha de egreso debe ser nula, si la modalidad es 'Plazo Determinado' la fecha de egreso debe ser obligatoria
    public function updatedModalidad($value)
    {
        if ($value == 2) {
            $this->validate([
                'nombre' => 'required',
                'apellido_paterno' => 'required',
                'apellido_materno' => 'required',
                'documento' => 'required',
                'fecha_nacimiento' => 'required',
                'genero' => 'required',
                'salario' => 'required',
                'fecha_ingreso' => 'required',
                'fecha_egreso' => 'required',
                'jornada_laboral' => 'required',
                'area' => 'required',
                'modalidad' => 'required',
            ]);
        }else{
            $this->validate([
                'nombre' => 'required',
                'apellido_paterno' => 'required',
                'apellido_materno' => 'required',
                'documento' => 'required',
                'fecha_nacimiento' => 'required',
                'genero' => 'required',
                'salario' => 'required',
                'fecha_ingreso' => 'required',
                'fecha_egreso' => 'nullable',
                'jornada_laboral' => 'required',
                'area' => 'required',
                'modalidad' => 'required',
            ]);
        }
    }

    public function updatedArea($value)
    {
        $this->salario = Area::find($value)->salario_base_area;
    }

    public function guardar()
    {

        if ($this->modalidad == 2) {
            $this->validate([
                'nombre' => 'required',
                'apellido_paterno' => 'required',
                'apellido_materno' => 'required',
                'documento' => 'required',
                'fecha_nacimiento' => 'required',
                'genero' => 'required',
                'salario' => 'required',
                'fecha_ingreso' => 'required',
                'fecha_egreso' => 'required',
                'jornada_laboral' => 'required',
                'area' => 'required',
                'modalidad' => 'required',
            ]);
        }else{
            $this->validate([
                'nombre' => 'required',
                'apellido_paterno' => 'required',
                'apellido_materno' => 'required',
                'documento' => 'required',
                'fecha_nacimiento' => 'required',
                'genero' => 'required',
                'salario' => 'required',
                'fecha_ingreso' => 'required',
                'fecha_egreso' => 'nullable',
                'jornada_laboral' => 'required',
                'area' => 'required',
                'modalidad' => 'required',
            ]);
        }

        try {

            DB::beginTransaction();

            $persona = new Persona();
            $persona->nombres_persona = $this->nombre;
            $persona->apellido_pat_persona = $this->apellido_paterno;
            $persona->apellido_mat_persona = $this->apellido_materno;
            $persona->documento_persona = $this->documento;
            $persona->fecha_naci_persona = $this->fecha_nacimiento;
            $persona->genero_persona = $this->genero;
            $persona->save();

            $empleado = new Empleado();
            $empleado->codigo_emp = generarCodigoEmpleado();
            $empleado->salario_emp = $this->salario;
            $empleado->fecha_ingreso_emp = $this->fecha_ingreso;
            if ($this->modalidad == 2 && $this->fecha_egreso != null) {
                $empleado->fecha_egreso_emp = $this->fecha_egreso;
            }
            $empleado->estado_emp = 1;
            $empleado->id_area = $this->area;
            $empleado->id_modalidad = $this->modalidad;
            $empleado->id_jornada_lab = $this->jornada_laboral;
            $empleado->id_persona = $persona->id_persona;
            $empleado->save();

            $historial = new HistorialSalario();
            $historial->id_emp = $empleado->id_emp;
            $historial->salario_act_historial = $this->salario;
            $historial->fecha_cambio_historial = date('Y-m-d');
            $historial->estado_historial = 1;
            $historial->save();

            //Asignar beneficios de acuerdo al tiempo que estara en la empresa
            $beneficios = Beneficio::all();
            foreach ($beneficios as $beneficio) {
                if($empleado->id_modalidad == 1){
                    $empleado->beneficio()->attach($beneficio->id_bene);
                }else{
                    if($beneficio->mes_bene == 0)
                    {
                        $empleado->beneficio()->attach($beneficio->id_bene);
                    }else{
                        $fechaIngreso = new DateTime($empleado->fecha_ingreso_emp);
                        $mesIngreso = (int)$fechaIngreso->format('m'); // 'm' es el formato para el número del mes
                        $fechaEgreso = new DateTime($empleado->fecha_egreso_emp);
                        $mesEgreso = (int)$fechaEgreso->format('m'); // 'm' es el formato para el número del mes
                        if($beneficio->mes_bene >= $mesIngreso && $beneficio->mes_bene <= $mesEgreso){
                            $empleado->beneficio()->attach($beneficio->id_bene);
                        }
                    }
                }
            }

            // dd($empleado->beneficio);

            DB::commit();

            session(['mensaje_guardar' => 'crear']);
            return redirect()->route('empleados');

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            $this->dispatch(
                'toast-basico',
                mensaje: 'Ocurrió un error al guardar el empleado'. $e->getMessage(),
                type: 'error'
            );
        }

    }

    public function render()
    {
        $area_model = Area::where('estado_area', 1)->get();
        $modalidad_model = Modalidad::where('estado_modalidad', 1)->get();
        $persona_model = Persona::noAdmin()->get();

        return view('livewire.empleado.create', [
            'area_model' => $area_model,
            'modalidad_model' => $modalidad_model,
            'persona_model' => $persona_model,
        ]);
    }
}
