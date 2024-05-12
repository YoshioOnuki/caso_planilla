<?php

use App\Models\Empleado;
use App\Models\Usuario;
use Illuminate\Support\Facades\Storage;

if (!function_exists('formatFechaHoras')) {
    function formatFechaHoras($fecha)
    {
        return date('h:i A d/m/Y', strtotime($fecha));
    }
}

if (!function_exists('formatFecha')) {
    function formatFecha($fecha)
    {
        return date('d/m/Y', strtotime($fecha));
    }
}

if (!function_exists('formatFechaMes')) {
    function formatMes($mes)
    {
        switch ($mes) {
            case 1:
                return 'Enero';
            case 2:
                return 'Febrero';
            case 3:
                return 'Marzo';
            case 4:
                return 'Abril';
            case 5:
                return 'Mayo';
            case 6:
                return 'Junio';
            case 7:
                return 'Julio';
            case 8:
                return 'Agosto';
            case 9:
                return 'Septiembre';
            case 10:
                return 'Octubre';
            case 11:
                return 'Noviembre';
            case 12:
                return 'Diciembre';
            case 0:
                return 'Todos los meses';
        }
    }
}

if (!function_exists('subirAvatar')) {
    function subirAvatar($file, $persona_id)
    {
        if ($file) {
            $usuario = Usuario::where('persona_id', $persona_id)->first();
            if ($usuario->usuario_avatar) {
                Storage::disk('public_file')->delete($usuario->usuario_avatar);
            }
        }
        $path = 'files/images/';
        $filename = time() . $persona_id . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs($path, $filename, 'public_file');
        $nombre_db = $path . $filename;

        return $nombre_db;
    }
}

if (!function_exists('generarCodigoEmpleado')) {
    function generarCodigoEmpleado()
    {
        $emp = Empleado::orderBy('id_emp', 'desc')->first();

        // Si no hay empleados registrados
        if (!$emp) {
            return 'EMP0001';
        }else{
            $id = ltrim(substr($emp->codigo_emp, 3), '0');
            $id++;

            $codigo = 'EMP';

            if ($id < 10) {
                $codigo .= '000' . $id;
            } elseif ($id < 100) {
                $codigo .= '00' . $id;
            } elseif ($id < 1000) {
                $codigo .= '0' . $id;
            } else {
                $codigo .= $id;
            }

            return $codigo;
        }
    }
}

// Con una fecha ingresada, sacar la antiguedad de la empresa en dias, meses y años
if (!function_exists('CalcularAntiguedadEmpresa')) {
    function CalcularAntiguedadEmpresa($fecha_ingreso, $fecha_actual)
    {
        $fecha_ingreso = $fecha_ingreso;
        $fecha_actual = $fecha_actual;
        $diferencia = date_diff($fecha_ingreso, $fecha_actual);
        $ant_empresa_dias = $diferencia->format('%a');

        $years = $diferencia->format('%y');
        $months = $diferencia->format('%m');
        $days = $diferencia->format('%d');
        $ant_empresa_meses = ($years * 12) + $months;

        //Concatena los años, meses y dias en formato UI
        $ant_empresa = '';
        if ($years > 0) {
            $ant_empresa .= $years . ' años ';
        }
        if ($months > 0) {
            $ant_empresa .= $months . ' meses ';
        }
        if ($days > 0) {
            $ant_empresa .= $days . ' días';
        }

        if ($ant_empresa == '') {
            $ant_empresa = '0 días';
        }

        return $ant_empresa;
    }
}