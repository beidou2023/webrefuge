<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Manager - MyRefuge</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .list-group-item {
            cursor: pointer;
            transition: all 0.3s;
        }
        .list-group-item:hover {
            background-color: #f8f9fa;
        }
        .list-group-item.active {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        #graficaRatas {
            max-height: 300px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">MyRefuge</a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    Manager: {{ $user->firstName }}
                </span>
                <a href="/logout" class="btn btn-outline-light btn-sm">Cerrar Sesión</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-4">
        <h1 class="mb-4">Dashboard Manager</h1>
        <div class="row">
            <aside class="col-md-3 border-end">
                <div class="list-group">
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

                <div class="card mt-4">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Estadísticas</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-1"><small>Total Ratas: <strong>{{ $stats['total_rats'] }}</strong></small></p>
                        <p class="mb-1"><small>Machos: <strong>{{ $stats['male_rats'] }}</strong></small></p>
                        <p class="mb-1"><small>Hembras: <strong>{{ $stats['female_rats'] }}</strong></small></p>
                        <p class="mb-1"><small>Especiales: <strong>{{ $stats['special_rats'] }}</strong></small></p>
                        <p class="mb-0"><small>Solicitudes Pendientes: <strong>{{ $stats['pending_requests'] }}</strong></small></p>
                    </div>
                </div>
            </aside>

            <div class="col-md-9">
                <div id="section-refugio">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3>Mi Refugio: {{ $refuge->name }}</h3>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#agregarRata">
                            <i class="bi bi-plus-circle me-1"></i>Agregar Rata
                        </button>
                    </div>

                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Distribución de Ratas</h5>
                            <canvas id="graficaRatas" width="200" height="100"></canvas>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h3 class="text-primary">{{ $stats['total_rats'] }}</h3>
                                    <p class="card-text">Total Ratas</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h3 class="text-info">{{ $stats['male_rats'] }}</h3>
                                    <p class="card-text">Machos</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h3 class="text-danger">{{ $stats['female_rats'] }}</h3>
                                    <p class="card-text">Hembras</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <p class="mt-3">
                        <strong>Dirección del refugio:</strong> {{ $refuge->address }}
                    </p>
                </div>

                <div id="section-especiales" class="d-none">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3>Ratas Especiales</h3>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarEspecial">
                            <i class="bi bi-plus-circle me-1"></i>Agregar Rata Especial
                        </button>
                    </div>

                    @if($specialRats->count() > 0)
                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        @foreach($specialRats as $rat)
                        <div class="col">
                            <div class="card shadow-sm h-100">
                                @if($rat->imgUrl)
                                <img src="{{ asset('storage/' . $rat->imgUrl) }}" class="card-img-top" alt="{{ $rat->name }}">
                                @else
                                <img src="https://placekitten.com/301/200" class="card-img-top" alt="{{ $rat->name }}">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $rat->name }}</h5>
                                    <p class="card-text">
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
                    <div class="alert alert-info">
                        <h5>No hay ratas especiales registradas</h5>
                        <p class="mb-0">Puedes agregar ratas especiales usando el botón superior.</p>
                    </div>
                    @endif
                </div>

                <div id="section-solicitudes" class="d-none">
                    <h3 class="mb-4">Solicitudes de Adopción Pendientes</h3>

                    @if($pendingRequests->count() > 0)
                        @foreach($pendingRequests as $request)
                        <div class="card mb-3 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h5>Solicitud #{{ $request->id }}</h5>
                                        <p class="mb-1"><strong>Usuario:</strong> {{ $request->user->email }}</p>
                                        <p class="mb-1"><strong>Motivo:</strong> {{ $request->reason }}</p>
                                        <p class="mb-1"><strong>Experiencia:</strong> {{ Str::limit($request->experience, 100) }}</p>
                                        <p class="mb-1"><strong>Cantidad esperada:</strong> {{ $request->quantityExpected }} ratas</p>
                                        <p class="mb-1"><strong>Teléfono de contacto:</strong> {{ $request->contactTravel ?? 'No especificado' }}</p>
                                        <p class="mb-0"><small class="text-muted">Solicitado: {{ $request->created_at->format('d/m/Y H:i') }}</small></p>
                                    </div>
                                    <div class="btn-group-vertical">
                                        <form action="{{ route('manager.request.process', $request->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="action" value="approve">
                                            <button type="submit" class="btn btn-success btn-sm mb-1">Aprobar</button>
                                        </form>
                                        <form action="{{ route('manager.request.process', $request->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="action" value="reject">
                                            <button type="submit" class="btn btn-danger btn-sm">Rechazar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                    <div class="alert alert-success">
                        <h5>No hay solicitudes pendientes</h5>
                        <p class="mb-0">Todas las solicitudes han sido procesadas.</p>
                    </div>
                    @endif
                </div>

                <div id="section-usuarios" class="d-none">
                    <h3 class="mb-4">Usuarios Registrados</h3>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
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
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                    onclick="return confirm('¿Estás seguro de banear a este usuario?')">
                                                Banear
                                            </button>
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

                    <p class="text-muted">Total usuarios: {{ $activeUsers->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="agregarRata" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Agregar Rata</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('manager.rat.add') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nombre (opcional)</label>
                            <input type="text" class="form-control" name="name" placeholder="Nombre de la rata">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sexo</label>
                            <select class="form-select" name="sex" required>
                                <option value="">Seleccionar...</option>
                                <option value="M">Macho</option>
                                <option value="F">Hembra</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Color (opcional)</label>
                            <input type="text" class="form-control" name="color" placeholder="Color de la rata">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Edad en meses (opcional)</label>
                            <input type="number" class="form-control" name="ageMonths" placeholder="Edad en meses" min="1" max="36">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Origen</label>
                            <input type="text" class="form-control" name="origin" placeholder="¿De dónde proviene la rata?" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Agregar Rata</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="agregarEspecial" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Agregar Rata Especial</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('manager.special-rat.add') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="name" placeholder="Nombre de la rata especial" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control" name="description" rows="3" placeholder="Descripción de la rata especial" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sexo</label>
                            <select class="form-select" name="sex" required>
                                <option value="">Seleccionar...</option>
                                <option value="M">Macho</option>
                                <option value="F">Hembra</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Edad en meses (opcional)</label>
                            <input type="number" class="form-control" name="ageMonths" placeholder="Edad en meses" min="1" max="36">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Imagen (opcional)</label>
                            <input type="file" class="form-control" name="imgUrl" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Agregar Rata Especial</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let graficaRatas = null;
    const stats = @json($stats);

    document.querySelectorAll('.list-group-item').forEach(btn => {
        btn.addEventListener('click', e => {
            document.querySelectorAll('.list-group-item').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            document.querySelectorAll('[id^="section-"]').forEach(sec => sec.classList.add('d-none'));
            document.getElementById(`section-${btn.dataset.section}`).classList.remove('d-none');
            
            if (btn.dataset.section === 'refugio') {
                initializeChart();
            }
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
                    data: [stats.male_rats, stats.female_rats, stats.special_rats],
                    backgroundColor: ['#0dcaf0', '#dc3545', '#ffc107'],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        if (document.getElementById('section-refugio') && 
            !document.getElementById('section-refugio').classList.contains('d-none')) {
            initializeChart();
        }
    });

    @if(session('success'))
        alert('{{ session('success') }}');
    @endif
</script>
</body>
</html>