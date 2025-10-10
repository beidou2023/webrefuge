<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - MyRefuge</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
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
        .stats-card {
            transition: transform 0.2s;
        }
        .stats-card:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">MyRefuge</a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    Admin: {{ $user->firstName }}
                </span>
                <a href="/logout" class="btn btn-outline-light btn-sm">Cerrar Sesión</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-4">
        <h1 class="mb-4">Dashboard Administrador</h1>
        
        <div class="row mb-4">
            <div class="col-xl-2 col-md-4 col-6 mb-3">
                <div class="card stats-card text-center bg-primary text-white">
                    <div class="card-body">
                        <h3>{{ $stats['total_users'] }}</h3>
                        <p class="card-text">Total Usuarios</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-6 mb-3">
                <div class="card stats-card text-center bg-warning text-white">
                    <div class="card-body">
                        <h3>{{ $stats['pending_users'] }}</h3>
                        <p class="card-text">Usuarios Pendientes</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-6 mb-3">
                <div class="card stats-card text-center bg-danger text-white">
                    <div class="card-body">
                        <h3>{{ $stats['banned_users'] }}</h3>
                        <p class="card-text">Usuarios Baneados</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-6 mb-3">
                <div class="card stats-card text-center bg-success text-white">
                    <div class="card-body">
                        <h3>{{ $stats['total_refuges'] }}</h3>
                        <p class="card-text">Total Refugios</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-6 mb-3">
                <div class="card stats-card text-center bg-info text-white">
                    <div class="card-body">
                        <h3>{{ $stats['total_rats'] }}</h3>
                        <p class="card-text">Total Ratas</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-6 mb-3">
                <div class="card stats-card text-center bg-secondary text-white">
                    <div class="card-body">
                        <h3>{{ $stats['pending_requests'] }}</h3>
                        <p class="card-text">Solicitudes Pendientes</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <aside class="col-md-3 border-end">
                <div class="list-group">
                    <button class="list-group-item active" data-section="usuarios">
                        <i class="bi bi-people me-2"></i>Usuarios
                    </button>
                    <button class="list-group-item" data-section="refugios">
                        <i class="bi bi-house me-2"></i>Refugios
                    </button>
                    <button class="list-group-item" data-section="informes">
                        <i class="bi bi-graph-up me-2"></i>Informes
                    </button>
                </div>
            </aside>

            <div class="col-md-9">
                <div id="section-usuarios">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3>Gestión de Usuarios</h3>
                        <small class="text-muted">Total: {{ $users->count() }} usuarios</small>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Teléfono</th>
                                    <th>Estado</th>
                                    <th>Rol</th>
                                    <th>Registro</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>
                                        <strong>{{ $user->firstName }} {{ $user->lastName }}</strong>
                                        @if($user->id == Auth::id())
                                            <span class="badge bg-info">Tú</span>
                                        @endif
                                    </td>
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
                                        @if($user->role == 1)
                                            <span class="badge bg-primary">Usuario</span>
                                        @elseif($user->role == 2)
                                            <span class="badge bg-warning">Manager</span>
                                        @elseif($user->role == 3)
                                            <span class="badge bg-danger">Admin</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $user->created_at->format('d/m/Y') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            @if($user->id != Auth::id())
                                                <form action="{{ route('admin.user.toggle-status', $user->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-{{ $user->status == 3 ? 'success' : 'danger' }} btn-sm" 
                                                            onclick="return confirm('¿{{ $user->status == 3 ? 'Activar' : 'Banear' }} usuario?')">
                                                        {{ $user->status == 3 ? 'Activar' : 'Banear' }}
                                                    </button>
                                                </form>

                                                <div class="dropdown d-inline">
                                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                        Rol
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <form action="{{ route('admin.user.change-role', $user->id) }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="new_role" value="1">
                                                                <button type="submit" class="dropdown-item">Usuario</button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('admin.user.change-role', $user->id) }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="new_role" value="2">
                                                                <button type="submit" class="dropdown-item">Manager</button>
                                                            </form>
                                                        </li>
                                                        @if(Auth::user()->role == 3) 
                                                        <li>
                                                            <form action="{{ route('admin.user.change-role', $user->id) }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="new_role" value="3">
                                                                <button type="submit" class="dropdown-item">Admin</button>
                                                            </form>
                                                        </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            @else
                                                <span class="text-muted small">Tú</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="section-refugios" class="d-none">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3>Gestión de Refugios</h3>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#nuevoRefugio">
                            <i class="bi bi-plus-circle me-1"></i>Nuevo Refugio
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Manager</th>
                                    <th>Contacto</th>
                                    <th>Ratas</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($refuges as $refuge)
                                <tr>
                                    <td>{{ $refuge->id }}</td>
                                    <td>
                                        <strong>{{ $refuge->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ Str::limit($refuge->address, 30) }}</small>
                                    </td>
                                    <td>
                                        {{ $refuge->manager->firstName ?? 'N/A' }} {{ $refuge->manager->lastName ?? '' }}
                                        <br>
                                        <small class="text-muted">{{ $refuge->manager->email }}</small>
                                    </td>
                                    <td>{{ $refuge->manager->phone ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $refuge->maleCount }}♂</span>
                                        <span class="badge bg-danger">{{ $refuge->femaleCount }}♀</span>
                                        <br>
                                        <small>Total: {{ $refuge->maleCount + $refuge->femaleCount }}</small>
                                    </td>
                                    <td>
                                        @if($refuge->status == 1)
                                            <span class="badge bg-success">Activo</span>
                                        @else
                                            <span class="badge bg-warning">Suspendido</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.refuge.toggle-status', $refuge->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-{{ $refuge->status == 1 ? 'warning' : 'success' }} btn-sm" 
                                                    onclick="return confirm('¿{{ $refuge->status == 1 ? 'Suspender' : 'Activar' }} refugio?')">
                                                {{ $refuge->status == 1 ? 'Suspender' : 'Activar' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Informes -->
                <div id="section-informes" class="d-none">
                    <h3 class="mb-4">Informes y Estadísticas</h3>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Distribución de Usuarios por Rol</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="userRoleChart" width="400" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Estado de Refugios</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="refugeStatusChart" width="400" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Resumen General</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-md-3">
                                            <h4 class="text-primary">{{ $stats['total_users'] }}</h4>
                                            <p class="text-muted">Total Usuarios</p>
                                        </div>
                                        <div class="col-md-3">
                                            <h4 class="text-success">{{ $stats['total_refuges'] }}</h4>
                                            <p class="text-muted">Total Refugios</p>
                                        </div>
                                        <div class="col-md-3">
                                            <h4 class="text-info">{{ $stats['total_rats'] }}</h4>
                                            <p class="text-muted">Total Ratas</p>
                                        </div>
                                        <div class="col-md-3">
                                            <h4 class="text-warning">{{ $stats['total_requests'] }}</h4>
                                            <p class="text-muted">Total Solicitudes</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="nuevoRefugio" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Crear Nuevo Refugio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.refuge.create') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Email del Manager</label>
                            <input type="email" class="form-control" name="manager_email" placeholder="correo@ejemplo.com" required>
                            <small class="form-text text-muted">El usuario debe existir en el sistema</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nombre del Refugio</label>
                            <input type="text" class="form-control" name="name" placeholder="Nombre del refugio" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contacto</label>
                            <input type="text" class="form-control" name="contact" placeholder="Teléfono de contacto" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Dirección</label>
                            <textarea class="form-control" name="address" rows="3" placeholder="Dirección completa" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Crear Refugio</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.list-group-item').forEach(btn => {
            btn.addEventListener('click', e => {
                document.querySelectorAll('.list-group-item').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                document.querySelectorAll('[id^="section-"]').forEach(sec => sec.classList.add('d-none'));
                document.getElementById(`section-${btn.dataset.section}`).classList.remove('d-none');
                
                if (btn.dataset.section === 'informes') {
                    initializeCharts();
                }
            });
        });

        function initializeCharts() {
            const userCtx = document.getElementById('userRoleChart');
            if (userCtx) {
                new Chart(userCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Usuarios', 'Managers', 'Admins'],
                        datasets: [{
                            data: [
                                {{ $users->where('role', 1)->count() }},
                                {{ $users->where('role', 2)->count() }},
                                {{ $users->where('role', 3)->count() }}
                            ],
                            backgroundColor: ['#0d6efd', '#ffc107', '#dc3545']
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            }

            const refugeCtx = document.getElementById('refugeStatusChart');
            if (refugeCtx) {
                new Chart(refugeCtx, {
                    type: 'pie',
                    data: {
                        labels: ['Activos', 'Suspendidos'],
                        datasets: [{
                            data: [
                                {{ $refuges->where('status', 1)->count() }},
                                {{ $refuges->where('status', 0)->count() }}
                            ],
                            backgroundColor: ['#198754', '#fd7e14']
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            }
        }

        @if(session('success'))
            alert('{{ session('success') }}');
        @endif

        @if(session('error'))
            alert('{{ session('error') }}');
        @endif
    </script>
</body>
</html>