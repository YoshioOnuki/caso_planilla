<div>
    <div class="page-header d-print-none animate__animated animate__fadeIn animate__faster">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('empleados') }}">Empleado</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="#">{{ $titulo }}</a></li>
                        </ol>
                    </div>
                    <h2 class="page-title text-uppercase">
                        {{ $titulo }}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">

            <div class="row g-5">
                <div class="col-12">
                    <div class="card card-stacke animate__animated animate__fadeIn animate__faster">
                        <form wire:submit="guardar">
                            <div class="card-body">
                                <div class="row py-2">
                                    <label class="col-3 col-form-label">
                                        Información del Empleado
                                    </label>
                                    <div class="col">
                                        <div class="row g-3">
                                            <div class="col-lg-6">
                                                <label for="documento" class="form-label {{ $modo === 'ver' ? '' : 'required' }}">
                                                    DNI / RUC / CE / Pasaporte 
                                                </label>
                                                <input type="number"
                                                    class="form-control @error('documento') is-invalid @enderror"
                                                    id="documento" wire:model.live="documento"
                                                    placeholder="Example: 00000000" {{ $modo == 'ver' ? 'disabled' : '' }} />
                                                @error('documento')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            @if($modo == 'ver')
                                                <div class="col-lg-2">
                                                    <label for="edad" class="form-label">
                                                        Edad
                                                    </label>
                                                    <input type="text"
                                                        class="form-control @error('edad') is-invalid @enderror"
                                                        id="edad" wire:model.live="edad" disabled />
                                                    @error('edad')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            @endif
                                            <div class="{{ $modo == 'ver' ? 'col-lg-4' : 'col-lg-6' }}">
                                                <label for="fecha_nacimiento" class="form-label {{ $modo === 'ver' ? '' : 'required' }}">
                                                    Fecha de Nacimiento
                                                </label>
                                                @if($modo == 'ver')
                                                    <input class="form-control @error('fecha_nacimiento') is-invalid @enderror"
                                                        id="fecha_nacimiento" wire:model.live="fecha_nacimiento" disabled/>
                                                @else
                                                    <input type="date"
                                                        class="form-control @error('fecha_nacimiento') is-invalid @enderror"
                                                        id="fecha_nacimiento" wire:model.live="fecha_nacimiento"
                                                        max="{{ date('Y-m-d') }}"/>
                                                    @error('fecha_nacimiento')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="apellido_paterno" class="form-label {{ $modo === 'ver' ? '' : 'required' }}">
                                                    Apellido Paterno
                                                </label>
                                                <input type="text"
                                                    class="form-control @error('apellido_paterno') is-invalid @enderror"
                                                    id="apellido_paterno" wire:model.live="apellido_paterno"
                                                    placeholder="Ingrese su apellido paterno" {{ $modo == 'ver' ? 'disabled' : '' }} />
                                                @error('apellido_paterno')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="apellido_materno" class="form-label {{ $modo === 'ver' ? '' : 'required' }}">
                                                    Apellido Materno
                                                </label>
                                                <input type="text"
                                                    class="form-control @error('apellido_materno') is-invalid @enderror"
                                                    id="apellido_materno" wire:model.live="apellido_materno"
                                                    placeholder="Ingrese su apellido materno" {{ $modo == 'ver' ? 'disabled' : '' }} />
                                                @error('apellido_materno')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-lg-12">
                                                <label for="nombre" class="form-label {{ $modo === 'ver' ? '' : 'required' }}">
                                                    Nombres
                                                </label>
                                                <input type="text"
                                                    class="form-control @error('nombre') is-invalid @enderror"
                                                    id="nombre" wire:model.live="nombre"
                                                    placeholder="Ingrese su nombre" {{ $modo == 'ver' ? 'disabled' : '' }} />
                                                @error('nombre')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="genero" class="form-label {{ $modo === 'ver' ? '' : 'required' }}">
                                                    Genero
                                                </label>
                                                @if($modo == 'ver')
                                                    <input type="text"
                                                        class="form-control @error('genero') is-invalid @enderror"
                                                        id="genero" wire:model.live="genero" disabled />
                                                @else
                                                    <select class="form-select @error('genero') is-invalid @enderror"
                                                        id="genero" wire:model.live="genero">
                                                        <option value="">
                                                            Seleccione un género
                                                        </option>
                                                        <option value="M" {{ $genero === 'M' ? 'selected' : '' }}>Masculino</option>
                                                        <option value="F" {{ $genero === 'F' ? 'selected' : '' }}>Femenino</option>
                                                    </select>
                                                @endif
                                                @error('genero')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="salario" class="form-label">
                                                    Salario
                                                </label>
                                                <input type="number"
                                                    class="form-control @error('salario') is-invalid @enderror"
                                                    id="salario" wire:model.live="salario" disabled/>
                                                @error('salario')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-lg-3">
                                                <label for="fecha_ingreso" class="form-label">
                                                    Fecha de Ingreso
                                                </label>
                                                <input class="form-control @error('fecha_ingreso') is-invalid @enderror"
                                                    id="fecha_ingreso" wire:model.live="fecha_ingreso" disabled/>
                                            </div>
                                            <div class="col-lg-3">
                                                <label for="fecha_egreso" class="form-label">
                                                    Fecha de Egreso
                                                </label>
                                                <input class="form-control @error('fecha_egreso') is-invalid @enderror"
                                                    id="fecha_egreso" wire:model.live="fecha_egreso" disabled/>
                                            </div>
                                            <div class="col-lg-3">
                                                <label for="ant_empresa" class="form-label">
                                                    Antigüedad en la Empresa
                                                </label>
                                                <input class="form-control @error('ant_empresa') is-invalid @enderror"
                                                    id="ant_empresa" wire:model.live="ant_empresa" disabled/>
                                            </div>
                                            <div class="col-lg-3">
                                                <label for="jornada_laboral" class="form-label">
                                                    Jornada Laboral
                                                </label>
                                                @if($modo == 'ver')
                                                    <input class="form-control @error('jornada_laboral') is-invalid @enderror"
                                                        id="jornada_laboral" wire:model.live="jornada_laboral" disabled/>
                                                @else
                                                    <select class="form-select @error('jornada_laboral') is-invalid @enderror"
                                                        id="jornada_laboral" wire:model.live="jornada_laboral">
                                                        <option value="">
                                                            Seleccione una jornada laboral
                                                        </option>
                                                        <option value="1" {{ $jornada_laboral === '1' ? 'selected' : '' }}>Tiempo Completo</option>
                                                        <option value="2" {{ $jornada_laboral === '2' ? 'selected' : '' }}>Medio Tiempo</option>
                                                    </select>
                                                    @error('jornada_laboral')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="area" class="form-label {{ $modo === 'ver' ? '' : 'required' }}">
                                                    Área
                                                </label>
                                                @if($modo == 'ver')
                                                <input class="form-control @error('area') is-invalid @enderror"
                                                    id="area" wire:model.live="area" disabled/>
                                                @else
                                                    <select class="form-select @error('area') is-invalid @enderror"
                                                        id="area" wire:model.live="area">
                                                        <option value="">
                                                            Seleccione un área
                                                        </option>
                                                        @foreach ($area_model as $item)
                                                            <option value="{{ $item->id_area }}">
                                                                {{ $item->nombre_area }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('area')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="modalidad" class="form-label {{ $modo === 'ver' ? '' : 'required' }}">
                                                    Modalidad
                                                </label>
                                                @if($modo == 'ver')
                                                <input class="form-control @error('modalidad') is-invalid @enderror"
                                                    id="modalidad" wire:model.live="modalidad" disabled/>
                                                @else
                                                    <select class="form-select @error('modalidad') is-invalid @enderror"
                                                        id="modalidad" wire:model.live="modalidad">
                                                        <option value="">
                                                            Seleccione una modalidad
                                                        </option>
                                                        @foreach ($modalidad_model as $item)
                                                            <option wire:key="{{ $item->id_modalidad }}"
                                                            value="{{ $item->id_modalidad }}">
                                                                {{ $item->nombre_modalidad }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('modalidad')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                @endif
                                            </div>
                                            @if($modalidad == 1)
                                                @php
                                                    $contrato_emp = App\Models\Empleado::where('estado_emp', 1)->where('id_persona', $id_persona)->where('id_emp', '!=', $id_emp)->first();
                                                @endphp
                                                @if(!$contrato_emp)
                                                    <div class="col-lg-12">
                                                        <div class="form-label">Estado</div>
                                                        <div>
                                                            @if($modo === 'ver')
                                                                <span class="status status-{{ $estado ? 'teal' : 'danger' }} px-3 py-2">
                                                                    <span class="status-dot status-dot-animated"></span>
                                                                    {{ $estado ? 'Contratado' : 'Inactivo' }}
                                                                </span>
                                                            @else
                                                                <label class="form-check form-check-inline">
                                                                    <input
                                                                        class="form-check-input @error('estado') is-invalid @enderror"
                                                                        type="checkbox" wire:model.live="estado" {{ $estado ? 'checked' : '' }} />
                                                                    <span class="form-check-label">Contratado</span>
                                                                </label>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($modo === 'ver')
                                <div class="card-body">
                                    <div class="row py-2">
                                        <label class="col-3 col-form-label">
                                            Beneficios
                                        </label>
                                        <div class="col">
                                            <table class="table card-table table-vcenter text-nowrap table-striped  datatable">
                                                <thead>
                                                    <tr>
                                                        <th class="w-1">No.</th>
                                                        <th>Beneficio</th>
                                                        <th>Monto</th>
                                                        <th>Tipo</th>
                                                        <th>Mes</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $i = 1;
                                                    @endphp
                                                    @forelse ($emp_bene_model as $item)
                                                        <tr>
                                                            <td>
                                                                <span class="text-secondary">{{ $i++ }}</span>
                                                            </td>
                                                            <td>
                                                                {{ $item->beneficio->nombre_bene }}
                                                            </td>
                                                            <td>
                                                                {{ $item->beneficio->monto_bene }}
                                                            </td>
                                                            <td>
                                                                {{ $item->beneficio->operacion_bene }}
                                                            </td>
                                                            <td>
                                                                {{ formatMes($item->beneficio->mes_bene) }}
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        @if ($emp_bene_model->count() == 0)
                                                            <tr>
                                                                <td colspan="5">
                                                                    <div class="text-center"
                                                                        style="padding-bottom: 1rem; padding-top: 1rem;">
                                                                        <span class="text-secondary">
                                                                            No hay beneficios registrados
                                                                        </span>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="card-footer text-end">
                                <a href="{{ route('empleados') }}" class="btn btn-outline-secondary">
                                    Regresar
                                </a>
                                @if($modo != 'ver')
                                    <button type="submit" class="btn btn-primary">
                                        Guardar
                                    </button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>