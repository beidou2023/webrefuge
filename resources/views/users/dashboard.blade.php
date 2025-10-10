@extends('content')

@section('section')
<div class="container my-5">

    {{-- Saludo y resumen --}}
    <div class="text-center mb-5">
        <h1 class="fw-bold" style="color: var(--section-title)">Bienvenido, {{ $user->firstName }} 👋</h1>
        <p class="text-muted">Aquí puedes ver tu información personal, tus adopciones y solicitudes.</p>
    </div>

    {{-- Información personal y estadísticas --}}
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card feature-card h-100">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-person-circle"></i> Mi Información</h5>
                    <p><strong>Nombre:</strong> {{ $user->firstName }} {{ $user->lastName }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Teléfono:</strong> {{ $user->phone ?? 'No registrado' }}</p>
                    <p><strong>Dirección:</strong> {{ $user->address ?? 'No registrada' }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card feature-card h-100">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-graph-up-arrow"></i> Mis Estadísticas</h5>
                    <div class="row text-center">
                        <div class="col">
                            <h3 class="fw-bold text-primary">{{ $rats->count() }}</h3>
                            <p class="text-muted small">Ratas Adoptadas</p>
                        </div>
                        <div class="col">
                            <h3 class="fw-bold text-warning">{{ $adoptionRequests->count() }}</h3>
                            <p class="text-muted small">Solicitudes Totales</p>
                        </div>
                        <div class="col">
                            <h3 class="fw-bold text-success">{{ $adoptionRequests->where('status', 1)->count() }}</h3>
                            <p class="text-muted small">Aprobadas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sección de ratas adoptadas --}}
    <h2 class="section-title mb-3"><i class="bi bi-heart-fill"></i> Mis Ratas ({{ $rats->count() }})</h2>
    @if($rats->count() > 0)
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($rats as $rat)
            <div class="col">
                <div class="card">
                    <div class="position-relative">
                        @if($rat->type == 2 && $rat->specialrat && $rat->specialrat->imgUrl)
                            <img src="{{ asset('storage/' . $rat->specialrat->imgUrl) }}" class="card-img-top" alt="{{ $rat->name }}">
                        @else
                            <img src="{{ asset('images/example.jpg') }}" class="card-img-top" alt="Rata {{ $rat->name }}">
                        @endif

                        <span class="badge position-absolute top-0 start-0 m-2 {{ $rat->sex == 'M' ? 'bg-info' : 'bg-danger' }}">
                            {{ $rat->sex == 'M' ? '♂ Macho' : '♀ Hembra' }}
                        </span>

                        <span class="badge position-absolute top-0 end-0 m-2 {{ $rat->type == 2 ? 'bg-warning' : 'bg-success' }}">
                            {{ $rat->type == 2 ? 'Especial' : 'Normal' }}
                        </span>
                    </div>

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $rat->name ?? 'Sin nombre' }}</h5>
                        <div class="mb-2">
                            @if($rat->color)
                                <span class="badge bg-secondary me-1">{{ $rat->color }}</span>
                            @endif
                            @if($rat->ageMonths)
                                <span class="badge bg-light text-dark">{{ $rat->ageMonths }} meses</span>
                            @endif
                        </div>

                        @if($rat->adoptedAt)
                            <p class="text-muted small mb-3">
                                <i class="bi bi-calendar-heart"></i> Adoptada el {{ $rat->adoptedAt->format('d/m/Y') }}
                            </p>
                        @endif

                        <div class="mt-auto d-flex gap-2">
                            <button class="btn btn-warning btn-sm flex-fill" data-bs-toggle="modal" 
                                data-bs-target="#reportModal" data-rat-id="{{ $rat->id }}" 
                                data-rat-name="{{ $rat->name ?? 'Sin nombre' }}">
                                <i class="bi bi-flag"></i> Reportar
                            </button>

                            <button class="btn btn-primary btn-sm flex-fill" data-bs-toggle="modal" 
                                data-bs-target="#renameModal" data-rat-id="{{ $rat->id }}" 
                                data-rat-name="{{ $rat->name ?? 'Sin nombre' }}">
                                <i class="bi bi-pencil"></i> Renombrar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info mt-3 shadow-sm">
            <h5><i class="bi bi-info-circle"></i> No tienes ratas adoptadas</h5>
            <p>Puedes solicitar la adopción de ratas disponibles en nuestro refugio.</p>
        </div>
    @endif

    <hr class="my-5">

    {{-- Solicitudes de adopción --}}
    <h2 class="section-title mb-3"><i class="bi bi-journal-check"></i> Mis Solicitudes</h2>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card feature-card h-100">
                <div class="card-body">
                    <h5 class="card-title">Historial de Solicitudes</h5>

                    @if($adoptionRequests->count() > 0)
                        <div class="list-group">
                            @foreach($adoptionRequests as $request)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>#{{ $request->id }}</strong> — {{ $request->quantityExpected }} ratas
                                    <br><small class="text-muted">Solicitado: {{ $request->created_at->format('d/m/Y') }}</small>
                                </div>
                                <span class="badge
                                    {{ $request->status == 0 ? 'bg-danger' : '' }}
                                    {{ $request->status == 1 ? 'bg-success' : '' }}
                                    {{ $request->status == 2 ? 'bg-warning' : '' }}">
                                    @if($request->status == 0) Rechazada
                                    @elseif($request->status == 1) Aprobada
                                    @else Pendiente
                                    @endif
                                </span>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">No tienes solicitudes registradas.</p>
                    @endif

                    <div class="mt-3">
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#adoptModal">
                            <i class="bi bi-heart"></i> Nueva Solicitud
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card feature-card h-100">
                <div class="card-body">
                    <h5 class="card-title">Acciones Rápidas</h5>
                    <div class="d-grid gap-2">
                        <a href="{{ route('user.rats.available') }}" class="btn btn-outline-success">
                            <i class="bi bi-search"></i> Ver Ratas Disponibles
                        </a>
                        <a href="{{ route('user.rats.special') }}" class="btn btn-outline-warning">
                            <i class="bi bi-star"></i> Ver Ratas Especiales
                        </a>
                        <a href="{{ route('user.profile') }}" class="btn btn-outline-info">
                            <i class="bi bi-person"></i> Mi Perfil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal scripts --}}

@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            alert(@json(session('success')));
        });
    </script>
@endif
@endsection
