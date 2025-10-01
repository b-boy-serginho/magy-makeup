@extends('layouts.app')

@section('content')
<div class="card mb-4">
    <div class="card-header">
        {{ __('Bitácora de Actividades') }}
    </div>

    <div class="card-body">
        <!-- Filtro -->
        {{-- <form method="GET" action="{{ route('bitacora.index') }}" class="mb-3 d-flex gap-2">
            <input
                type="text"
                name="action"
                class="form-control"
                placeholder="Filtrar por acción"
                value="{{ request('action') }}"
            >
            <button type="submit" class="btn btn-primary">Filtrar</button>
            @if(request()->has('action') && request('action') !== null)
                <a href="{{ route('bitacora.index') }}" class="btn btn-outline-secondary">Limpiar</a>
            @endif
        </form> --}}

        <!-- Tabla -->
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th scope="col">Usuario</th>
                        <th scope="col">Acción</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($activityLogs as $log)
                        <tr>
                            <td>{{ $log->user?->name ?? 'Desconocido' }}</td>
                            <td>{{ $log->action }}</td>
                            <td style="white-space: pre-wrap">{{ $log->description }}</td>
                            <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                No hay registros en la bitácora.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginación -->
    <div class="card-footer">
        {{ $activityLogs->links() }}
    </div>
</div>
@endsection
