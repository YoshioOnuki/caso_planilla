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
    #[Validate('nullable')]
    public $empleado_existente;

    //Funcion update, si la modalidad es 'Plazo Indeterminado' la fecha de egreso debe ser nula, si la modalidad es 'Plazo Determinado' la fecha de egreso debe ser obligatoria
    public function updatedModalidad($value)
    {
        if ($value == 2) {
            if($this->existe == true){
                $this->validate([
                    'nombre' => 'nullable',
                    'apellido_paterno' => 'nullable',
                    'apellido_materno' => 'nullable',
                    'documento' => 'nullable',
                    'fecha_nacimiento' => 'nullable',
                    'genero' => 'nullable',
                    'salario' => 'required',
                    'fecha_ingreso' => 'required',
                    'fecha_egreso' => 'required',
                    'jornada_laboral' => 'required',
                    'area' => 'required',
                    'modalidad' => 'required',
                    'empleado_existente' => 'required',
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
                    'fecha_egreso' => 'required',
                    'jornada_laboral' => 'required',
                    'area' => 'required',
                    'modalidad' => 'required',
                    'empleado_existente' => 'nullable',
                ]);
            }
        }else{
            if($this->existe == true){
                $this->validate([
                    'nombre' => 'nullable',
                    'apellido_paterno' => 'nullable',
                    'apellido_materno' => 'nullable',
                    'documento' => 'nullable',
                    'fecha_nacimiento' => 'nullable',
                    'genero' => 'nullable',
                    'salario' => 'required',
                    'fecha_ingreso' => 'required',
                    'fecha_egreso' => 'nullable',
                    'jornada_laboral' => 'required',
                    'area' => 'required',
                    'modalidad' => 'required',
                    'empleado_existente' => 'required',
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
                    'empleado_existente' => 'nullable',
                ]);
            }
        }
    }

    public function updatedArea($value)
    {
        $this->salario = Area::find($value)->salario_base_area;
    }

    public function guardar()
    {

        if ($this->modalidad == 2) {
            if($this->existe == true){
                $this->validate([
                    'nombre' => 'nullable',
                    'apellido_paterno' => 'nullable',
                    'apellido_materno' => 'nullable',
                    'documento' => 'nullable',
                    'fecha_nacimiento' => 'nullable',
                    'genero' => 'nullable',
                    'salario' => 'required',
                    'fecha_ingreso' => 'required',
                    'fecha_egreso' => 'required',
                    'jornada_laboral' => 'required',
                    'area' => 'required',
                    'modalidad' => 'required',
                    'empleado_existente' => 'required',
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
                    'fecha_egreso' => 'required',
                    'jornada_laboral' => 'required',
                    'area' => 'required',
                    'modalidad' => 'required',
                    'empleado_existente' => 'nullable',
                ]);
            }
            
        }else{
            if($this->existe == true){
                $this->validate([
                    'nombre' => 'nullable',
                    'apellido_paterno' => 'nullable',
                    'apellido_materno' => 'nullable',
                    'documento' => 'nullable',
                    'fecha_nacimiento' => 'nullable',
                    'genero' => 'nullable',
                    'salario' => 'required',
                    'fecha_ingreso' => 'required',
                    'fecha_egreso' => 'nullable',
                    'jornada_laboral' => 'required',
                    'area' => 'required',
                    'modalidad' => 'required',
                    'empleado_existente' => 'required',
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
                    'empleado_existente' => 'nullable',
                ]);
            }
        }

        try {

            DB::beginTransaction();

            $persona = collect();

            if($this->existe == true){
                $persona = Persona::where('id_persona', $this->empleado_existente)->first();
            }else{
                $persona = new Persona();
                $persona->nombres_persona = $this->nombre;
                $persona->apellido_pat_persona = $this->apellido_paterno;
                $persona->apellido_mat_persona = $this->apellido_materno;
                $persona->documento_persona = $this->documento;
                $persona->fecha_naci_persona = $this->fecha_nacimiento;
                $persona->genero_persona = $this->genero;
                $persona->save();
            }

            $validar_contratos_existentes = Empleado::where('id_persona', $persona->id_persona)->where('estado_emp', 1)->get();
            if($validar_contratos_existentes->count() > 0){
                $this->dispatch(
                    'toast-basico',
                    mensaje: 'El empleado ya tiene un contrato activo',
                    type: 'error'
                );
                return;
            }

            // Cambiar el estado de permiso_contrato_emp a 0
            $permiso_contrato = Empleado::where('id_persona', $persona->id_persona)->where('permiso_contrato_emp', 1)->get();
            foreach ($permiso_contrato as $permiso) {
                $permiso->permiso_contrato_emp = 0;
                $permiso->save();
            }

            $empleado = new Empleado();
            $empleado->codigo_emp = generarCodigoEmpleado();
            $empleado->salario_emp = $this->salario;
            $empleado->fecha_ingreso_emp = $this->fecha_ingreso;
            if ($this->modalidad == 2 && $this->fecha_egreso != null) {
                $empleado->fecha_egreso_emp = $this->fecha_egreso;
            }
            $empleado->estado_emp = 1;
            $empleado->permiso_contrato_emp = 1;
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
                mensaje: 'Ocurrió un error al guardar el empleado - '. $e->getMessage(),
                type: 'error'
            );
        }

    }

    public function render()
    {
        $area_model = Area::where('estado_area', 1)->get();
        $modalidad_model = Modalidad::where('estado_modalidad', 1)->get();
        $persona_model = Persona::noAdmin()->empleadoInactivo()->get();

        return view('livewire.empleado.create', [
            'area_model' => $area_model,
            'modalidad_model' => $modalidad_model,
            'persona_model' => $persona_model,
        ]);
    }
}
