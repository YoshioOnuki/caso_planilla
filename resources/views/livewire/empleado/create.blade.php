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
                                    href="#">CREAR EMPLEADO</a></li>
                        </ol>
                    </div>
                    <h2 class="page-title text-uppercase">
                        CREAR EMPLEADO
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
                                        ¿El empleado ya existe?
                                    </label>
                                    <div class="col">
                                        <div class="row g-3">
                                            <div class="col-lg-12">
                                                <div class="form-label"></div>
                                                <div>
                                                    <label class="form-check form-check-inline">
                                                        <input
                                                            class="form-check-input @error('existe') is-invalid @enderror"
                                                            type="checkbox" wire:model.live="existe" {{ $existe ? 'checked' : '' }} />
                                                        <span class="form-check-label">Existe</span>
                                                    </label>
                                                </div>
                                            </div>
                                            @if($existe)
                                                <div class="col-lg-12">
                                                    <label for="empleado_existe" class="form-label required">
                                                        Empleado
                                                    </label>
                                                    <select class="form-select @error('empleado_existe') is-invalid @enderror"
                                                        id="empleado_existe" wire:model.live="empleado_existe">
                                                        <option value="">
                                                            Seleccione un empleado
                                                        </option>
                                                        @foreach ($persona_model as $item)
                                                            <option value="{{ $item->id_persona }}">
                                                                {{ $item->nombres_persona }} {{ $item->apellido_pat_persona }} {{ $item->apellido_mat_persona }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('empleado_existe')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @if(!$existe)
                                    <hr>
                                    <div class="row py-2">
                                        <label class="col-3 col-form-label">
                                            Datos del empleado
                                        </label>
                                        <div class="col">
                                            <div class="row g-3">
                                                <div class="col-lg-6">
                                                    <label for="documento" class="form-label required">
                                                        DNI / RUC / CE / Pasaporte 
                                                    </label>
                                                    <input type="number"
                                                        class="form-control @error('documento') is-invalid @enderror"
                                                        id="documento" wire:model.live="documento"
                                                        placeholder="Example: 00000000"/>
                                                    @error('documento')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="fecha_nacimiento" class="form-label required">
                                                        Fecha de Nacimiento
                                                    </label>
                                                    <input type="date"
                                                        class="form-control @error('fecha_nacimiento') is-invalid @enderror"
                                                        id="fecha_nacimiento" wire:model.live="fecha_nacimiento"
                                                        max="{{ date('Y-m-d') }}"/>
                                                    @error('fecha_nacimiento')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="apellido_paterno" class="form-label required">
                                                        Apellido Paterno
                                                    </label>
                                                    <input type="text"
                                                        class="form-control @error('apellido_paterno') is-invalid @enderror"
                                                        id="apellido_paterno" wire:model.live="apellido_paterno"
                                                        placeholder="Ingrese su apellido paterno"/>
                                                    @error('apellido_paterno')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="apellido_materno" class="form-label required">
                                                        Apellido Materno
                                                    </label>
                                                    <input type="text"
                                                        class="form-control @error('apellido_materno') is-invalid @enderror"
                                                        id="apellido_materno" wire:model.live="apellido_materno"
                                                        placeholder="Ingrese su apellido materno"/>
                                                    @error('apellido_materno')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12">
                                                    <label for="nombre" class="form-label required">
                                                        Nombres
                                                    </label>
                                                    <input type="text"
                                                        class="form-control @error('nombre') is-invalid @enderror"
                                                        id="nombre" wire:model.live="nombre"
                                                        placeholder="Ingrese su nombre"/>
                                                    @error('nombre')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="genero" class="form-label required">
                                                        Genero
                                                    </label>
                                                    <select class="form-select @error('genero') is-invalid @enderror"
                                                        id="genero" wire:model.live="genero">
                                                        <option value="">
                                                            Seleccione un género
                                                        </option>
                                                        <option value="M">Masculino</option>
                                                        <option value="F">Femenino</option>
                                                    </select>
                                                    @error('genero')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <hr>
                                <div class="row py-2">
                                    <label class="col-3 col-form-label">
                                        Datos del contrato
                                    </label>
                                    <div class="col">
                                        <div class="row g-3">
                                            <div class="col-lg-6">
                                                <label for="jornada_laboral" class="form-label required">
                                                    Jornada Laboral
                                                </label>
                                                <select class="form-select @error('jornada_laboral') is-invalid @enderror"
                                                    id="jornada_laboral" wire:model.live="jornada_laboral">
                                                    <option value="">
                                                        Seleccione una jornada laboral
                                                    </option>
                                                    <option value="1">Tiempo completo</option>
                                                    <option value="2">Medio tiempo</option>
                                                </select>
                                                @error('jornada_laboral')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="modalidad" class="form-label required">
                                                    Modalidad
                                                </label>
                                                <select class="form-select @error('modalidad') is-invalid @enderror"
                                                    id="modalidad" wire:model.live="modalidad">
                                                    <option value="">
                                                        Seleccione una modalidad
                                                    </option>
                                                    @foreach ($modalidad_model as $item)
                                                        <option value="{{ $item->id_modalidad }}">
                                                            {{ $item->nombre_modalidad }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('modalidad')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-lg-{{ $modalidad == 2 ? '3' : '6' }}">
                                                <label for="fecha_ingreso" class="form-label required">
                                                    Fecha de Ingreso
                                                </label>
                                                <input type="date"
                                                    class="form-control @error('fecha_ingreso') is-invalid @enderror"
                                                    id="fecha_ingreso" wire:model.live="fecha_ingreso"
                                                    min="{{ date('Y-m-d') }}"/>
                                                @error('fecha_ingreso')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            @if ($modalidad == 2)
                                                <div class="col-lg-3">
                                                    <label for="fecha_egreso" class="form-label {{ $modalidad == 2 ? 'required' : '' }}">
                                                        Fecha de Egreso
                                                    </label>
                                                    <input type="date"
                                                        class="form-control @error('fecha_egreso') is-invalid @enderror"
                                                        id="fecha_egreso" wire:model.live="fecha_egreso"
                                                        min="{{ date('Y-m-d') }}"/>
                                                    @error('fecha_egreso')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            @endif
                                            <div class="col-lg-6">
                                                <label for="area" class="form-label required">
                                                    Área
                                                </label>
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
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="salario" class="form-label">
                                                    Salario
                                                </label>
                                                <input type="number"
                                                    class="form-control"
                                                    id="salario" wire:model.live="salario"placeholder="0.00" disabled/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer text-end">
                                <a href="{{ route('empleados') }}" class="btn btn-outline-secondary">
                                    Regresar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    Guardar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>