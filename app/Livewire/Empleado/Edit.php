<?php

namespace App\Livewire\Empleado;

use App\Models\Area;
use App\Models\Empleado;
use App\Models\EmpleadoBeneficio;
use App\Models\HistorialSalario;
use App\Models\Modalidad;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Edit extends Component
{
    public $titulo = 'Ver Empleado';
    public $modo = 'ver';

    // Datos del empleado
    public $id_emp;
    #[Validate('required')]
    public $nombre;
    #[Validate('required')]
    public $apellido_paterno;
    #[Validate('required')]
    public $apellido_materno;
    #[Validate('required')]
    public $documento;
    public $edad;
    #[Validate('required')]
    public $fecha_nacimiento;
    #[Validate('required')]
    public $genero;
    public $salario;
    public $fecha_ingreso;
    public $fecha_egreso;
    public $jornada_laboral;
    #[Validate('required')]
    public $area;
    #[Validate('required')]
    public $modalidad;
    public $ant_empresa;
    public $estado;

    public $id_persona;

    public function mount($id_emp)
    {
        $this->id_emp = $id_emp;
        $this->id_persona = Empleado::find($id_emp)->id_persona;
        $this->modo = session('modo');
        $this->titulo = $this->modo === 'ver' ? 'Ver Empleado' : 'Editar Empleado';

        $empleado = Empleado::find($id_emp);
        $this->nombre = $empleado->persona->nombres_persona;
        $this->apellido_paterno = $empleado->persona->apellido_pat_persona;
        $this->apellido_materno = $empleado->persona->apellido_mat_persona;
        $this->documento = $empleado->persona->documento_persona;
        $this->fecha_nacimiento = $empleado->persona->fecha_naci_persona;
        if($this->modo === 'ver')
        {
            $this->jornada_laboral = $empleado->jornadaLaboral->nombre_jornada_lab;
        }else{
            $this->jornada_laboral = $empleado->id_jornada_lab;
        }
        $this->edad = date_diff(date_create($this->fecha_nacimiento), date_create('now'))->y;
        if($this->modo === 'ver')
        {
            $this->genero = $empleado->persona->genero_persona === 'M' ? 'Masculino' : 'Femenino';
        }else{
            $this->genero = $empleado->persona->genero_persona;
        }
        $this->salario = $empleado->salario_emp;
        $this->fecha_ingreso = $empleado->fecha_ingreso_emp;
        $this->fecha_egreso = $empleado->fecha_egreso_emp;
        if($this->modo === 'ver')
        {
            $this->area = $empleado->area->nombre_area;
            $this->modalidad = $empleado->modalidad->nombre_modalidad;
        }else{
            $this->area = $empleado->id_area;
            $this->modalidad = $empleado->id_modalidad;
        }

        $fecha_ingreso = date_create($this->fecha_ingreso);
        $this->ant_empresa = CalcularAntiguedadEmpresa($fecha_ingreso, date_create('now'));
        
        $this->estado = $empleado->estado_emp;
    }

    public function guardar()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            $empleado = Empleado::find($this->id_emp);
            $empleado->fecha_ingreso_emp = $this->fecha_ingreso;
            if($empleado->id_area != $this->area)
            {
                $salario_ant = $empleado->salario_emp;
                $empleado->salario_emp = Area::find($this->area)->salario_base_area;

                // Historial de salario anterior se cambia a inactivo
                $historial_ant = HistorialSalario::where('id_emp', $this->id_emp)
                    ->where('estado_historial', 1)->first();
                if($historial_ant)
                {
                    $historial_ant->estado_historial = 0;
                    $historial_ant->save();
                }
                // Se genera el historial de salario
                $historial = new HistorialSalario();
                $historial->salario_act_historial = $empleado->salario_emp;
                $historial->salario_ant_historial = $salario_ant;
                $historial->fecha_cambio_historial = date('Y-m-d');
                $historial->estado_historial = 1;
                $historial->id_emp = $this->id_emp;
                $historial->save();
            }
            $empleado->id_area = $this->area;
            $empleado->id_modalidad = $this->modalidad;
            $empleado->id_jornada_lab = $this->jornada_laboral;
            if($this->estado == null)
            {
                $this->estado = 0;
            }
            $empleado->estado_emp = $this->estado;
            $empleado->save();

            $persona = $empleado->persona;
            $persona->nombres_persona = $this->nombre;
            $persona->apellido_pat_persona = $this->apellido_paterno;
            $persona->apellido_mat_persona = $this->apellido_materno;
            $persona->documento_persona = $this->documento;
            $persona->fecha_naci_persona = $this->fecha_nacimiento;
            $persona->genero_persona = $this->genero;
            $persona->save();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            session(['mensaje_guardar' => 'error']);
        }
        
        session(['mensaje_guardar' => 'editar']);
        return redirect()->route('empleados');
    }

    public function render()
    {
        $area_model = Area::where('estado_area', 1)->get();
        $modalidad_model = Modalidad::where('estado_modalidad', 1)->get();
        $emp_bene_model = EmpleadoBeneficio::where('id_emp', $this->id_emp)->get();

        return view('livewire.empleado.edit', [
            'area_model' => $area_model,
            'modalidad_model' => $modalidad_model,
            'emp_bene_model' => $emp_bene_model,
        ]);
    }
}
