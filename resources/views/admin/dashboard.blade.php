@extends('content')

@section('section')
<div class="container-fluid mt-4">
    {{-- Título --}}
    <h1 class="mb-4 fw-bold">Dashboard Administrador</h1>

    {{-- Estadísticas principales --}}
<div class="row mb-4 g-3">
    @php
        // Colores para las estadísticas
        $colors = [
            'total_users' => 'primary',
            'pending_users' => 'warning',
            'banned_users' => 'danger',
            'total_refuges' => 'success',
            'total_rats' => 'info',
            'pending_requests' => 'secondary',
        ];
    @endphp

    @foreach($colors as $key => $color)
        @if(isset($stats[$key])) {{-- Solo mostrar si existe la clave --}}
            <div class="col-xl-2 col-md-4 col-6">
                <div class="card shadow-sm stats-card text-center bg-{{ $color }} text-white p-3">
                    <h3 class="mb-1">{{ $stats[$key] }}</h3>
                    <p class="mb-0 text-uppercase small">{{ str_replace('_', ' ', $key) }}</p>
                </div>
            </div>
        @endif
    @endforeach
</div>

    <div class="row g-4">
        {{-- Sidebar --}}
        <aside class="col-md-3">
            <div class="list-group shadow-sm rounded">
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

        {{-- Contenido principal --}}
        <div class="col-md-9">
            {{-- Sección Usuarios --}}
            <div id="section-usuarios">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="fw-bold">Gestión de Usuarios</h3>
                    <small class="text-muted">Total: {{ $users->count() }} usuarios</small>
                </div>
                <div class="table-responsive shadow-sm rounded">
                    <table class="table table-striped table-hover align-middle">
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
                            @foreach($users as $u)
                            <tr>
                                <td>{{ $u->id }}</td>
                                <td>
                                    <strong>{{ $u->firstName }} {{ $u->lastName }}</strong>
                                    @if($u->id == Auth::id())
                                        <span class="badge bg-info">Tú</span>
                                    @endif
                                </td>
                                <td>{{ $u->email }}</td>
                                <td>{{ $u->phone }}</td>
                                <td>
                                    @switch($u->status)
                                        @case(1)<span class="badge bg-success">Activo</span>@break
                                        @case(2)<span class="badge bg-warning">Pendiente</span>@break
                                        @case(3)<span class="badge bg-danger">Baneado</span>@break
                                        @default<span class="badge bg-secondary">Inactivo</span>
                                    @endswitch
                                </td>
                                <td>
                                    @switch($u->role)
                                        @case(1)<span class="badge bg-primary">Usuario</span>@break
                                        @case(2)<span class="badge bg-warning">Manager</span>@break
                                        @case(3)<span class="badge bg-danger">Admin</span>@break
                                    @endswitch
                                </td>
                                <td><small class="text-muted">{{ $u->created_at->format('d/m/Y') }}</small></td>
                                <td>
                                    @if($u->id != Auth::id())
                                    <div class="btn-group btn-group-sm">
                                        <form action="{{ route('admin.user.toggle-status', $u->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-{{ $u->status == 3 ? 'success' : 'danger' }}" 
                                                onclick="return confirm('¿{{ $u->status == 3 ? 'Activar' : 'Banear' }} usuario?')">
                                                {{ $u->status == 3 ? 'Activar' : 'Banear' }}
                                            </button>
                                        </form>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                Rol
                                            </button>
                                            <ul class="dropdown-menu">
                                                @foreach([1=>'Usuario',2=>'Manager',3=>'Admin'] as $r => $label)
                                                    @if($r == 3 && Auth::user()->role != 3) @continue @endif
                                                    <li>
                                                        <form action="{{ route('admin.user.change-role', $u->id) }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="new_role" value="{{ $r }}">
                                                            <button type="submit" class="dropdown-item">{{ $label }}</button>
                                                        </form>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    @else
                                        <span class="text-muted small">Tú</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Sección Refugios --}}
            <div id="section-refugios" class="d-none">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="fw-bold">Gestión de Refugios</h3>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#nuevoRefugio">
                        <i class="bi bi-plus-circle me-1"></i>Nuevo Refugio
                    </button>
                </div>
                <div class="table-responsive shadow-sm rounded">
                    <table class="table table-bordered table-striped align-middle">
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
                            @foreach($refuges as $ref)
                            <tr>
                                <td>{{ $ref->id }}</td>
                                <td>
                                    <strong>{{ $ref->name }}</strong>
                                    <br>
                                    <small class="text-muted">{{ Str::limit($ref->address, 30) }}</small>
                                </td>
                                <td>
                                    {{ $ref->manager->firstName ?? 'N/A' }} {{ $ref->manager->lastName ?? '' }}
                                    <br>
                                    <small class="text-muted">{{ $ref->manager->email ?? '' }}</small>
                                </td>
                                <td>{{ $ref->manager->phone ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $ref->maleCount }}♂</span>
                                    <span class="badge bg-danger">{{ $ref->femaleCount }}♀</span>
                                    <br><small>Total: {{ $ref->maleCount + $ref->femaleCount }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $ref->status == 1 ? 'success' : 'warning' }}">
                                        {{ $ref->status == 1 ? 'Activo' : 'Suspendido' }}
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('admin.refuge.toggle-status', $ref->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-{{ $ref->status == 1 ? 'warning' : 'success' }} btn-sm"
                                            onclick="return confirm('¿{{ $ref->status == 1 ? 'Suspender' : 'Activar' }} refugio?')">
                                            {{ $ref->status == 1 ? 'Suspender' : 'Activar' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Sección Informes --}}
            <div id="section-informes" class="d-none">
                <h3 class="fw-bold mb-3">Informes y Estadísticas</h3>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                Distribución de Usuarios por Rol
                            </div>
                            <div class="card-body">
                                <canvas id="userRoleChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                Estado de Refugios
                            </div>
                            <div class="card-body">
                                <canvas id="refugeStatusChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card shadow-sm text-center p-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <h4 class="text-primary">{{ $stats['total_users'] }}</h4>
                                    <p class="text-muted">Usuarios</p>
                                </div>
                                <div class="col-md-3">
                                    <h4 class="text-success">{{ $stats['total_refuges'] }}</h4>
                                    <p class="text-muted">Refugios</p>
                                </div>
                                <div class="col-md-3">
                                    <h4 class="text-info">{{ $stats['total_rats'] }}</h4>
                                    <p class="text-muted">Ratas</p>
                                </div>
                                <div class="col-md-3">
                                    <h4 class="text-warning">{{ $stats['total_requests'] }}</h4>
                                    <p class="text-muted">Solicitudes</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>

    {{-- Modal Nuevo Refugio --}}
    <div class="modal fade" id="nuevoRefugio" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content shadow-sm rounded">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Crear Nuevo Refugio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.refuge.create') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Email del Manager</label>
                            <input type="email" class="form-control" name="manager_email" required placeholder="correo@ejemplo.com">
                            <small class="text-muted">El usuario debe existir en el sistema</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nombre del Refugio</label>
                            <input type="text" class="form-control" name="name" required placeholder="Nombre del refugio">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contacto</label>
                            <input type="text" class="form-control" name="contact" required placeholder="Teléfono de contacto">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Dirección</label>
                            <textarea class="form-control" name="address" rows="3" required placeholder="Dirección completa"></textarea>
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

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Navegación entre secciones
        document.querySelectorAll('.list-group-item').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.list-group-item').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                document.querySelectorAll('[id^="section-"]').forEach(sec => sec.classList.add('d-none'));
                document.getElementById(`section-${btn.dataset.section}`).classList.remove('d-none');

                if(btn.dataset.section === 'informes') initCharts();
            });
        });

        function initCharts() {
            const userCtx = document.getElementById('userRoleChart');
            if(userCtx) {
                new Chart(userCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Usuarios', 'Managers', 'Admins'],
                        datasets: [{
                            data: [
                                {{ $users->where('role',1)->count() }},
                                {{ $users->where('role',2)->count() }},
                                {{ $users->where('role',3)->count() }}
                            ],
                            backgroundColor: ['#0d6efd','#ffc107','#dc3545']
                        }]
                    },
                    options: { responsive:true, plugins:{legend:{position:'bottom'}} }
                });
            }

            const refugeCtx = document.getElementById('refugeStatusChart');
            if(refugeCtx) {
                new Chart(refugeCtx, {
                    type: 'pie',
                    data: {
                        labels: ['Activos','Suspendidos'],
                        datasets: [{
                            data: [
                                {{ $refuges->where('status',1)->count() }},
                                {{ $refuges->where('status',0)->count() }}
                            ],
                            backgroundColor: ['#198754','#fd7e14']
                        }]
                    },
                    options: { responsive:true, plugins:{legend:{position:'bottom'}} }
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

    <style>
        .stats-card { transition: transform 0.2s, box-shadow 0.2s; cursor: default; }
        .stats-card:hover { transform: translateY(-3px); box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1); }
        .list-group-item { cursor: pointer; transition: all 0.3s; }
        .list-group-item:hover { background-color: #f1f3f5; }
        .list-group-item.active { background-color: #0d6efd; color: #fff; }
        table tr:hover { background-color: #f8f9fa; }
    </style>
</div>
@endsection
