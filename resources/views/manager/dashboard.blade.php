@extends('content')

@section('section')
<div class="container-fluid mt-4">
    <div class="row g-4">
        {{-- Sidebar --}}
        <aside class="col-md-3">
            <div class="list-group mb-4 sticky-top" style="top: 20px;">
                <button class="list-group-item active" data-section="refugio">
                    <i class="bi bi-house me-2"></i>Mi Refugio
                </button>
                <button class="list-group-item" data-section="especiales">
                    <i class="bi bi-star me-2"></i>Ratas Especiales
                </button>
                <button class="list-group-item" data-section="solicitudes">
                    <i class="bi bi-clipboard-check me-2"></i>Solicitudes
                    @if($pendingRequests->count() > 0)
                        <span class="badge bg-danger float-end">{{ $pendingRequests->count() }}</span>
                    @endif
                </button>
                <button class="list-group-item" data-section="usuarios">
                    <i class="bi bi-people me-2"></i>Usuarios
                </button>
            </div>

            {{-- Estadísticas rápidas --}}
<div class="card shadow-sm mb-4" style="max-height: 250px; overflow-y: auto;">
    <div class="card-header bg-light py-2">
        <h6 class="mb-0 fw-bold">Estadísticas</h6>
    </div>
    <div class="card-body p-2">
        @php $safeStats = $stats ?? []; @endphp
        <p class="mb-1"><small>Total Ratas: <strong>{{ $safeStats['total_rats'] ?? 0 }}</strong></small></p>
        <p class="mb-1"><small>Machos: <strong>{{ $safeStats['male_rats'] ?? 0 }}</strong></small></p>
        <p class="mb-1"><small>Hembras: <strong>{{ $safeStats['female_rats'] ?? 0 }}</strong></small></p>
        <p class="mb-1"><small>Especiales: <strong>{{ $safeStats['special_rats'] ?? 0 }}</strong></small></p>
        <p class="mb-0"><small>Solicitudes Pendientes: <strong>{{ $safeStats['pending_requests'] ?? 0 }}</strong></small></p>
    </div>
</div>
        </aside>

        {{-- Contenido principal --}}
        <div class="col-md-9">
            {{-- Sección Refugio --}}
            <div id="section-refugio">
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                    <h3 class="fw-bold mb-2">Mi Refugio: {{ $refuge->name }}</h3>
                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#agregarRata">
                        <i class="bi bi-plus-circle me-1"></i>Agregar Rata
                    </button>
                </div>

                {{-- Gráfica --}}
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Distribución de Ratas</h5>
                        <canvas id="graficaRatas" style="max-height: 250px;"></canvas>
                    </div>
                </div>

                {{-- Resumen de ratas --}}
                <div class="row g-3">
                    @foreach(['total_rats'=>'Total Ratas', 'male_rats'=>'Machos', 'female_rats'=>'Hembras'] as $key => $label)
                        <div class="col-md-4">
                            <div class="card text-center shadow-sm p-3">
                                <h3 class="text-primary">{{ $safeStats[$key] ?? 0 }}</h3>
                                <p class="mb-0">{{ $label }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <p class="mt-3"><strong>Dirección del refugio:</strong> {{ $refuge->address }}</p>
            </div>

            {{-- Sección Ratas Especiales --}}
            <div id="section-especiales" class="d-none">
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                    <h3 class="fw-bold mb-2">Ratas Especiales</h3>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#agregarEspecial">
                        <i class="bi bi-plus-circle me-1"></i>Agregar Rata Especial
                    </button>
                </div>

                @if($specialRats->count() > 0)
                    <div class="row row-cols-1 row-cols-md-3 g-3">
                        @foreach($specialRats as $rat)
                            <div class="col">
                                <div class="card shadow-sm h-100">
                                    <img src="{{ $rat->imgUrl ? asset('storage/' . $rat->imgUrl) : 'https://placekitten.com/301/200' }}" 
                                         class="card-img-top" alt="{{ $rat->name }}">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $rat->name }}</h5>
                                        <p>
                                            <span class="badge {{ $rat->sex == 'M' ? 'bg-info' : 'bg-danger' }}">
                                                {{ $rat->sex == 'M' ? 'Macho' : 'Hembra' }}
                                            </span>
                                            <span class="badge bg-warning">Especial</span>
                                        </p>
                                        <p class="card-text">{{ Str::limit($rat->description, 100) }}</p>
                                        <small class="text-muted">Refugio: {{ $rat->refuge->name ?? 'N/A' }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info shadow-sm">
                        <h5>No hay ratas especiales registradas</h5>
                        <p class="mb-0">Puedes agregar ratas especiales usando el botón superior.</p>
                    </div>
                @endif
            </div>

            {{-- Sección Solicitudes --}}
<div id="section-solicitudes" class="d-none">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Solicitudes de Adopción Pendientes</h3>
        <span class="badge bg-warning text-dark fs-6">{{ $normalRequests->count() + $specialRequests->count() }} pendientes</span>
    </div>

    {{-- Pestañas para Normal/Especial --}}
    <ul class="nav nav-tabs mb-4" id="requestsTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="normal-tab" data-bs-toggle="tab" data-bs-target="#normal" type="button" role="tab">
                🐭 Normales 
                <span class="badge bg-primary ms-1">{{ $normalRequests->count() }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="special-tab" data-bs-toggle="tab" data-bs-target="#special" type="button" role="tab">
                ⭐ Especiales 
                <span class="badge bg-warning ms-1">{{ $specialRequests->count() }}</span>
            </button>
        </li>
    </ul>

    <div class="tab-content" id="requestsTabContent">
        
        {{-- Pestaña Solicitudes Normales --}}
        <div class="tab-pane fade show active" id="normal" role="tabpanel">
            @if($normalRequests->count() > 0)
                @foreach($normalRequests as $request)
                    <div class="card mb-4 shadow-sm border-0">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="bi bi-person-circle"></i> 
                                Solicitud #{{ $request->id }} - Adopción Normal
                            </h5>
                            <span class="badge bg-secondary">Normal</span>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <h6>👤 Información del Solicitante</h6>
                                        <p class="mb-1"><strong>Nombre:</strong> {{ $request->user->firstName }} {{ $request->user->lastName }}</p>
                                        <p class="mb-1"><strong>Email:</strong> {{ $request->user->email }}</p>
                                        <p class="mb-1"><strong>Teléfono:</strong> {{ $request->user->phone ?? 'No registrado' }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <h6>📋 Detalles de la Solicitud</h6>
                                        <p class="mb-1"><strong>Motivo:</strong> {{ $request->reason }}</p>
                                        <p class="mb-1"><strong>Experiencia:</strong> {{ $request->experience }}</p>
                                        <p class="mb-1"><strong>Cantidad esperada:</strong> {{ $request->quantityExpected }} ratas</p>
                                        <p class="mb-1"><strong>Tipo:</strong> 
                                            @if($request->couple == 1) Pareja 
                                            @elseif($request->couple == 0) Solo machos 
                                            @else Solo hembras 
                                            @endif
                                        </p>
                                    </div>

                                    <div class="mb-3">
                                        <h6>📞 Contactos de Emergencia</h6>
                                        <p class="mb-1"><strong>En viajes:</strong> {{ $request->contactTravel }}</p>
                                        <p class="mb-1"><strong>Para devolución:</strong> {{ $request->contactReturn }}</p>
                                    </div>

                                    @if($request->hasPets)
                                        <div class="alert alert-info">
                                            <h6>🐾 Mascotas Actuales</h6>
                                            <p class="mb-0">{{ $request->petsInfo ?? 'No especificó información' }}</p>
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-4 d-flex flex-column h-100">
                                    @if($request->imgUrl)
                                        <div class="mb-3">
                                            <h6>🏠 Foto de la Jaula</h6>
                                            <img src="{{ asset('images/users/CR4.jpg') }}"
                                                class="img-fluid rounded shadow-sm mb-2"
                                                alt="Rata {{ $rat->name }}"
                                                style="max-height: 200px; width: 100%; object-fit: cover;">
                                            <small class="text-muted">Hábitat preparado por el solicitante</small>
                                        </div>
                                    @endif

                                    <div class="card bg-light mt-auto">
                                        <div class="card-body">
                                            <h6>✅ Compromisos Aceptados</h6>
                                            <ul class="list-unstyled small mb-0">
                                                <li>{{ $request->noReturn ? '✓' : '✗' }} No devolución</li>
                                                <li>{{ $request->care ? '✓' : '✗' }} Cuidado adecuado</li>
                                                <li>{{ $request->followUp ? '✓' : '✗' }} Seguimiento</li>
                                                <li>{{ $request->canPayVet ? '✓' : '✗' }} Gastos veterinarios</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top">
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    Solicitado: {{ $request->created_at->format('d/m/Y H:i') }}
                                </small>
                                <div class="btn-group">
                                    <form action="{{ route('manager.request.process', $request->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="action" value="approve">
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="bi bi-check-lg"></i> Aprobar
                                        </button>
                                    </form>
                                    <form action="{{ route('manager.request.process', $request->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="action" value="reject">
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-x-lg"></i> Rechazar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="alert alert-success text-center py-4">
                    <i class="bi bi-check-circle display-4 text-success mb-3"></i>
                    <h4>¡No hay solicitudes normales pendientes!</h4>
                    <p class="mb-0">Todas las solicitudes de adopción normal han sido procesadas.</p>
                </div>
            @endif
        </div>

        {{-- Pestaña Solicitudes Especiales --}}
        <div class="tab-pane fade" id="special" role="tabpanel">
            @if($specialRequests->count() > 0)
                @foreach($specialRequests as $request)
                    <div class="card mb-4 shadow-sm border-warning">
                        <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="bi bi-star-fill"></i> 
                                Solicitud #{{ $request->id }} - Rata Especial
                            </h5>
                            <span class="badge bg-dark">Especial</span>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    {{-- Información de la Rata Especial --}}
                                    @if($request->specialRat)
                                        <div class="alert alert-warning">
                                            <h6>⭐ Rata Especial Solicitada</h6>
                                            <p class="mb-1"><strong>Nombre:</strong> {{ $request->specialRat->name }}</p>
                                            <p class="mb-1"><strong>Descripción:</strong> {{ $request->specialRat->description }}</p>
                                            <p class="mb-0"><strong>Necesidades especiales:</strong> {{ $request->specialRat->special_needs ?? 'No especificado' }}</p>
                                        </div>
                                    @endif

                                    <div class="mb-3">
                                        <h6>👤 Información del Solicitante</h6>
                                        <p class="mb-1"><strong>Nombre:</strong> {{ $request->user->firstName }} {{ $request->user->lastName }}</p>
                                        <p class="mb-1"><strong>Email:</strong> {{ $request->user->email }}</p>
                                        <p class="mb-1"><strong>Teléfono:</strong> {{ $request->user->phone ?? 'No registrado' }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <h6>📋 Detalles de la Solicitud Especial</h6>
                                        <p class="mb-1"><strong>Motivo específico:</strong> {{ $request->reason }}</p>
                                        <p class="mb-1"><strong>Experiencia con necesidades especiales:</strong> {{ $request->experience }}</p>
                                        <p class="mb-1"><strong>Cantidad:</strong> 1 rata especial</p>
                                    </div>

                                    <div class="mb-3">
                                        <h6>📞 Contactos de Emergencia</h6>
                                        <p class="mb-1"><strong>En viajes:</strong> {{ $request->contactTravel }}</p>
                                        <p class="mb-1"><strong>Para devolución:</strong> {{ $request->contactReturn }}</p>
                                    </div>

                                    @if($request->hasPets)
                                        <div class="alert alert-info">
                                            <h6>🐾 Mascotas Actuales</h6>
                                            <p class="mb-0">{{ $request->petsInfo ?? 'No especificó información' }}</p>
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-4 d-flex flex-column h-100">
                                    @if($request->imgUrl)
                                        <div class="mb-3">
                                            <h6>🏠 Foto de la Jaula</h6>
                                            <img src="{{ asset('images/users/AF5.jpg') }}"
                                                class="img-fluid rounded shadow-sm mb-2"
                                                alt="Rata {{ $rat->name }}"
                                                style="max-height: 200px; width: 100%; object-fit: cover;">
                                            <small class="text-muted">Hábitat preparado por el solicitante</small>
                                        </div>
                                    @endif

                                    <div class="card bg-light mt-auto">
                                        <div class="card-body">
                                            <h6>✅ Compromisos Aceptados</h6>
                                            <ul class="list-unstyled small mb-0">
                                                <li>{{ $request->noReturn ? '✓' : '✗' }} No devolución</li>
                                                <li>{{ $request->care ? '✓' : '✗' }} Cuidado adecuado</li>
                                                <li>{{ $request->followUp ? '✓' : '✗' }} Seguimiento</li>
                                                <li>{{ $request->canPayVet ? '✓' : '✗' }} Gastos veterinarios</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top">
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    Solicitado: {{ $request->created_at->format('d/m/Y H:i') }}
                                </small>
                                <div class="btn-group">
                                    <form action="{{ route('manager.request.process', $request->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="action" value="approve">
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="bi bi-check-lg"></i> Aprobar
                                        </button>
                                    </form>
                                    <form action="{{ route('manager.request.process', $request->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="action" value="reject">
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-x-lg"></i> Rechazar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="alert alert-info text-center py-4">
                    <i class="bi bi-star display-4 text-info mb-3"></i>
                    <h4>No hay solicitudes especiales pendientes</h4>
                    <p class="mb-0">Todas las solicitudes de adopción especial han sido procesadas.</p>
                </div>
            @endif
        </div>
    </div>
</div>

            {{-- Sección Usuarios --}}
            <div id="section-usuarios" class="d-none">
                <h3 class="fw-bold mb-4">Usuarios Registrados</h3>
                <div class="table-responsive shadow-sm">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Teléfono</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($activeUsers as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->firstName }} {{ $user->lastName }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>
                                        @if($user->status == 1)
                                            <span class="badge bg-success">Activo</span>
                                        @elseif($user->status == 2)
                                            <span class="badge bg-warning">Pendiente</span>
                                        @elseif($user->status == 3)
                                            <span class="badge bg-danger">Baneado</span>
                                        @else
                                            <span class="badge bg-secondary">Inactivo</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->status == 1)
                                            <form action="{{ route('manager.user.ban', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de banear a este usuario?')">Banear</button>
                                            </form>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <p class="text-muted mt-2">Total usuarios: {{ $activeUsers->count() }}</p>
            </div>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let graficaRatas = null;
    const stats = @json($safeStats);

    document.querySelectorAll('.list-group-item').forEach(btn => {
        btn.addEventListener('click', e => {
            document.querySelectorAll('.list-group-item').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            document.querySelectorAll('[id^="section-"]').forEach(sec => sec.classList.add('d-none'));
            document.getElementById(`section-${btn.dataset.section}`).classList.remove('d-none');
            
            if (btn.dataset.section === 'refugio') initializeChart();
        });
    });

    function initializeChart() {
        const ctx = document.getElementById('graficaRatas');
        if (!ctx) return;
        if (graficaRatas) graficaRatas.destroy();

        graficaRatas = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Machos', 'Hembras', 'Especiales'],
                datasets: [{
                    data: [stats.male_rats ?? 0, stats.female_rats ?? 0, stats.special_rats ?? 0],
                    backgroundColor: ['#0dcaf0', '#dc3545', '#ffc107'],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        if (document.getElementById('section-refugio')) initializeChart();
        @if(session('success')) alert('{{ session('success') }}'); @endif
    });
</script>

<style>
    body { background-color: #f5f6f8; }
    .card { border-radius: 1rem; box-shadow: 0 0.25rem 0.75rem rgba(0,0,0,0.08); transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .card:hover { transform: translateY(-2px); box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.12); }
    .list-group-item { border-radius: 0.5rem; margin-bottom: 6px; transition: all 0.3s ease; }
    .list-group-item:hover { background-color: #f1f3f5; }
    .list-group-item.active { background-color: #198754; color: #fff; }
    .card-img-top { max-height: 180px; object-fit: cover; border-top-left-radius: 1rem; border-top-right-radius: 1rem; }
    .sticky-top { top: 20px; }
</style>
@endsection
