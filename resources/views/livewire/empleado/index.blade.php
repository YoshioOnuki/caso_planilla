<div>
    <div class="page-header d-print-none animate__animated animate__fadeIn animate__faster">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="#">Empleados</a></li>
                        </ol>
                    </div>
                    <h2 class="page-title text-uppercase">
                        Empleados
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('empleados.crear') }}" class="btn btn-primary d-none d-sm-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Crear empleado
                        </a>
                        <a href="{{ route('empleados.crear') }}" class="btn btn-primary d-sm-none btn-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div wire:init="mostrar_toast"></div>
            <div class="row g-3">
                <div class="col-12">
                    <div class="card animate__animated animate__fadeIn animate__faster">
                        <div class="card-body border-bottom py-3">
                            <div class="d-flex">
                                <div class="text-secondary">
                                    Mostrar
                                    <div class="mx-2 d-inline-block">
                                        <select wire:model.live="mostrar_paginate" class="form-select form-select-sm">
                                            <option value="5">5</option>
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                        </select>
                                    </div>
                                    entradas
                                </div>
                                <div class="ms-auto text-secondary">
                                    Buscar:
                                    <div class="ms-2 d-inline-block">
                                        <input type="text" class="form-control form-control-sm"
                                            wire:model.live.debounce.500ms="search" aria-label="Search invoice">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap table-striped  datatable">
                                <thead>
                                    <tr>
                                        <th class="w-1">No.</th>
                                        <th>Empleado</th>
                                        <th>Salario</th>
                                        <th>F. Ingreso</th>
                                        <th>Estado</th>
                                        <th>Area</th>
                                        <th>Modalidad</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @forelse ($empleados as $item)
                                        <tr>
                                            <td>
                                                <span class="text-secondary">{{ $i++ }}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex py-1 align-items-center">
                                                    <img src="{{ asset($item->persona->avatar) }}" alt="avatar"
                                                        class="avatar me-2">
                                                    <div class="flex-fill">
                                                        <div class="font-weight-medium">{{ $item->nombre_completo }}
                                                        </div>
                                                        <div class="text-secondary"><a href="#"
                                                                class="text-reset">{{ $item->persona->documento_persona }}</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $item->salario_emp }}
                                            </td>
                                            <td>
                                                {{ formatFecha($item->fecha_ingreso_emp) }}
                                            </td>
                                            <td>
                                                @if ($item->estado_emp == 1)
                                                    <span class="status status-teal px-3 py-2">
                                                        <span class="status-dot status-dot-animated"></span>
                                                        Contratado
                                                    </span>
                                                @else
                                                    <span class="status status-red px-3 py-2">
                                                        <span class="status-dot status-dot-animated"></span>
                                                        Inactivo
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $item->area->nombre_area }}
                                            </td>
                                            <td>
                                                {{ $item->modalidad->nombre_modalidad }}
                                            </td>
                                            <td>
                                                <div class="btn-list flex-nowrap">
                                                    <a href="{{ route('empleados.salario', $item->id_emp) }}" class="btn btn-cyan">
                                                        Cambiar salario
                                                    </a>
                                                    <div class="dropdown">
                                                        <button class="btn dropdown-toggle align-text-top"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            Acciones
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end" >
                                                            <a class="dropdown-item" wire:click="datos({{ $item->id_emp }}, 'ver')"
                                                                style="cursor: pointer;">
                                                                Ver
                                                            </a>
                                                            <a class="dropdown-item" wire:click="datos({{ $item->id_emp }}, 'editar')"
                                                                style="cursor: pointer;">
                                                                Editar
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        @if ($empleados->count() == 0 && $search != '')
                                            <tr>
                                                <td colspan="7">
                                                    <div class="text-center"
                                                        style="padding-bottom: 5rem; padding-top: 5rem;">
                                                        <span class="text-secondary">
                                                            No se encontraron resultados para
                                                            "<strong>{{ $search }}</strong>"
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="7">
                                                    <div class="text-center"
                                                        style="padding-bottom: 5rem; padding-top: 5rem;">
                                                        <span class="text-secondary">
                                                            No hay empleados registrados
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer {{ $empleados->hasPages() ? 'py-0' : '' }}">
                            @if ($empleados->hasPages())
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex align-items-center text-secondary">
                                        Mostrando {{ $empleados->firstItem() }} - {{ $empleados->lastItem() }} de
                                        {{ $empleados->total() }} registros
                                    </div>
                                    <div class="mt-3">
                                        {{ $empleados->links() }}
                                    </div>
                                </div>
                            @else
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex align-items-center text-secondary">
                                        Mostrando {{ $empleados->firstItem() }} - {{ $empleados->lastItem() }} de
                                        {{ $empleados->total() }} registros
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
