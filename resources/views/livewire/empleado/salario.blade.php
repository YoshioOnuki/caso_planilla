<div>
    <div class="page-header d-print-none animate__animated animate__fadeIn animate__faster">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('empleados') }}">Empleado</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="#">Historial de Salario</a></li>
                        </ol>
                    </div>
                    <h2 class="page-title text-uppercase">
                        Historial de Salario del empleado
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <a href="{{ route('empleados') }}" class="btn btn-outline-secondary mb-3">
                Regresar
            </a>
            <div class="row g-3">
                <div class="col-12">
                    <div class="card animate__animated animate__fadeIn animate__faster">
                        <div class="card-body border-bottom py-3">
                            <div>
                                <h3>
                                    {{ $empleado->persona->nombres_persona }} {{ $empleado->persona->apellido_pat_persona }} 
                                    {{ $empleado->persona->apellido_pat_persona }} - {{ $empleado->codigo_emp }}
                                </h3>
                            </div>
                            {{-- <div class="d-flex mb-2 align-items-center justify-content-between">
                                <div class="row g-5 w-100">
                                    <div class="col-md-3">
                                        <label for="salario_nuevo" class="form-label required">
                                            Nuevo salario
                                        </label>
                                        <input type="number" class="form-control @error('salario_nuevo') is-invalid @enderror"
                                            id="salario_nuevo" wire:model="salario_nuevo" placeholder="Ingrese el nuevo salario">
                                        @error('salario_nuevo')
                                            <span class="form-text text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="salario_act" class="form-label">
                                            Salario actual
                                        </label>
                                        <input type="text" class="form-control" id="salario_act" wire:model="salario_act" disabled>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="salario_ant" class="form-label">
                                            Salario anterior
                                        </label>
                                        <input type="text" class="form-control" id="salario_ant" wire:model="salario_ant" disabled>
                                    </div>

                                    <div class="col-md-3 d-flex align-items-end justify-content-end">
                                        <button type="button" class="btn btn-primary" wire:click="actualizar_salario">
                                            Actualizar
                                        </button>
                                    </div>
                                    
                                </div>
                            </div> --}}
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap table-striped  datatable">
                                <thead>
                                    <tr>
                                        <th class="w-1">No.</th>
                                        <th>Salario actual</th>
                                        <th>Salario anterior</th>
                                        <th>Fecha</th>
                                        <th>N° pagos registrados</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @forelse ($salarios as $item)
                                        <tr>
                                            <td>
                                                <span class="text-secondary">{{ $i++ }}</span>
                                            </td>
                                            <td>
                                                {{ $item->salario_act_historial }}
                                            </td>
                                            <td>
                                                {{ $item->salario_ant_historial ?? 'N/A' }}
                                            </td>
                                            <td>
                                                {{ $item->fecha_cambio_historial }}
                                            </td>
                                            @php
                                                $pagos = App\Models\Pago::where('id_emp', $item->id_emp)->get();
                                                $cantidad = 0;
                                                foreach ($pagos as $pago)
                                                {
                                                    if ($pago->id_historial === $item->id_historial)
                                                    {
                                                        $cantidad++;
                                                    }
                                                }
                                            @endphp
                                            <td>
                                                {{ $cantidad }}
                                            </td>
                                            <td>
                                                @if ($item->estado_historial === 1)
                                                    <span class="status status-primary px-3 py-2">
                                                        <span class="status-dot status-dot-animated"></span>
                                                        Vigente
                                                    </span>
                                                @else
                                                    <span class="status status-red px-3 py-2">
                                                        <span class="status-dot status-dot-animated"></span>
                                                        Inactivo
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        @if ($salarios->count() === 0)
                                            <tr>
                                                <td colspan="7">
                                                    <div class="text-center"
                                                        style="padding-bottom: 1rem; padding-top: 1rem;">
                                                        <span class="text-secondary">
                                                            No hay historial de salarios registrados del empleado
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
            </div>
        </div>
    </div>
</div>
