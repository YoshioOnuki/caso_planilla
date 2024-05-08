<div>
    <div class="page-header d-print-none animate__animated animate__fadeIn animate__faster">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="#">Perfil</a>
                            </li>
                        </ol>
                    </div>
                    <h2 class="page-title text-uppercase">
                        Perfil
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="card card-stacked animate__animated animate__fadeIn animate__faster">
                <form autocomplete="off" wire:submit="guardar">
                    <div class="row g-0">
                        <div class="col-12 col-md-3 border-end">
                            <div class="card-body">
                                <h4 class="subheader">
                                    Configuración
                                </h4>
                                <div class="list-group list-group-transparent">
                                    <div
                                        class="list-group-item list-group-item-action d-flex align-items-center active">
                                        Perfil
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-9 d-flex flex-column">
                            <div class="card-body">
                                <h2 class="mb-4">
                                    Editar Perfil
                                </h2>
                                <div class="row g-3 mb-3">
                                    <div class="col-lg-4">
                                        <label for="apellido_paterno" class="form-label required">
                                            Apellido Paterno
                                        </label>
                                        <input type="text"
                                            class="form-control @error('apellido_paterno') is-invalid @enderror"
                                            id="apellido_paterno" wire:model.live="apellido_paterno"
                                            placeholder="Ingrese su apellido paterno" />
                                        @error('apellido_paterno')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="apellido_materno" class="form-label required">
                                            Apellido Materno
                                        </label>
                                        <input type="text"
                                            class="form-control @error('apellido_materno') is-invalid @enderror"
                                            id="apellido_materno" wire:model.live="apellido_materno"
                                            placeholder="Ingrese su apellido materno" />
                                        @error('apellido_materno')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="nombre" class="form-label required">
                                            Nombres
                                        </label>
                                        <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                            id="nombre" wire:model.live="nombre" placeholder="Ingrese su nombre" />
                                        @error('nombre')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-lg-4">
                                        <label for="documento" class="form-label required">
                                            DNI / RUC / CE / Pasaporte
                                        </label>
                                        <input type="text" class="form-control @error('documento') is-invalid @enderror"
                                            id="documento" wire:model.live="documento" placeholder="Ingrese su documento" />
                                        @error('documento')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="fecha_nacimiento" class="form-label required">
                                            Fecha de nacimiento
                                        </label>
                                        <input type="date" class="form-control @error('fecha_nacimiento') is-invalid @enderror"
                                            id="fecha_nacimiento" wire:model.live="fecha_nacimiento"
                                            max="{{ date('Y-m-d') }}"/>
                                        @error('fecha_nacimiento')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="genero" class="form-label required">
                                            Género
                                        </label>
                                        <select class="form-select @error('genero') is-invalid @enderror"
                                            id="genero" wire:model.live="genero">
                                            <option value="">
                                                Seleccione un género
                                            </option>
                                            <option value="M" {{ $genero === 'M' ? 'selected' : '' }}>Masculino</option>
                                            <option value="F" {{ $genero === 'F' ? 'selected' : '' }}>Femenino</option>
                                        </select>
                                        @error('documento')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <hr>
                                <div class="row g-3">
                                    <div class="col-lg-4">
                                        <label for="contraseña" class="form-label">
                                            Modificar Contraseña
                                        </label>
                                        <input type="password"
                                            class="form-control @error('contraseña') is-invalid @enderror"
                                            id="contraseña" wire:model.live="contraseña"
                                            placeholder="Ingrese su contraseña" />
                                        @error('contraseña')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="confirmar_contraseña" class="form-label">
                                            Confirmación de Contraseña
                                        </label>
                                        <input type="password"
                                            class="form-control @error('confirmar_contraseña') is-invalid @enderror"
                                            id="confirmar_contraseña" wire:model.live="confirmar_contraseña"
                                            placeholder="Ingrese su confirmación de contraseña" />
                                        @error('confirmar_contraseña')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent mt-auto">
                                <div class="btn-list justify-content-end">
                                    <button type="submit" class="btn btn-primary">
                                        Guardar Cambios
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>