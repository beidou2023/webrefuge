<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Usuario - MyRefuge</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .sex-badge {
            font-size: 0.8rem;
        }
        .status-badge {
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">MyRefuge</a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    Hola, {{ $user->firstName }}
                </span>
                <a href="/logout" class="btn btn-outline-light btn-sm">Cerrar Sesión</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="mb-4">Dashboard Usuario</h1>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Mi Información</h5>
                        <p><strong>Nombre:</strong> {{ $user->firstName }} {{ $user->lastName }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Teléfono:</strong> {{ $user->phone }}</p>
                        <p><strong>Dirección:</strong> {{ $user->address }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Mis Estadísticas</h5>
                        <p><strong>Ratas Adoptadas:</strong> {{ $rats->count() }}</p>
                        <p><strong>Solicitudes de Adopción:</strong> {{ $adoptionRequests->count() }}</p>
                        <p><strong>Solicitudes Pendientes:</strong> {{ $adoptionRequests->where('status', 2)->count() }}</p>
                        <p><strong>Solicitudes Aprobadas:</strong> {{ $adoptionRequests->where('status', 1)->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="mb-3">Mis Ratas ({{ $rats->count() }})</h2>
        
        @if($rats->count() > 0)
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($rats as $rat)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="position-relative">
                        @if($rat->type == 2 && $rat->specialrat && $rat->specialrat->imgUrl)
                            <img src="{{ asset('storage/' . $rat->specialrat->imgUrl) }}" class="card-img-top" alt="{{ $rat->name }}">
                        @else
                            <img src="{{ asset('images/example.jpg') }}" class="card-img-top" alt="Rata {{ $rat->name }}">
                        @endif
                        
                        <span class="badge sex-badge position-absolute top-0 start-0 m-2 {{ $rat->sex == 'M' ? 'bg-info' : 'bg-danger' }}">
                            {{ $rat->sex == 'M' ? '♂ Macho' : '♀ Hembra' }}
                        </span>
                        
                        <span class="badge status-badge position-absolute top-0 end-0 m-2 {{ $rat->type == 2 ? 'bg-warning' : 'bg-success' }}">
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
                                <i class="bi bi-calendar-heart"></i> 
                                Adoptada: {{ $rat->adoptedAt->format('d/m/Y') }}
                            </p>
                        @endif

                        <div class="mt-auto d-flex gap-2">
                            <button class="btn btn-warning btn-sm flex-fill" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#reportModal"
                                    data-rat-id="{{ $rat->id }}"
                                    data-rat-name="{{ $rat->name ?? 'Sin nombre' }}">
                                <i class="bi bi-flag"></i> Reportar
                            </button>
                            <button class="btn btn-primary btn-sm flex-fill" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#renameModal"
                                    data-rat-id="{{ $rat->id }}"
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
        <div class="alert alert-info">
            <h5><i class="bi bi-info-circle"></i> No tienes ratas adoptadas</h5>
            <p class="mb-0">Puedes solicitar la adopción de ratas disponibles en nuestro refugio.</p>
        </div>
        @endif

        <hr class="my-4">

        <h2 class="mb-3">Adopción</h2>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Solicitudes de Adopción</h5>
                        <p>Tienes {{ $adoptionRequests->count() }} solicitudes de adopción.</p>
                        
                        @if($adoptionRequests->count() > 0)
                        <div class="list-group">
                            @foreach($adoptionRequests as $request)
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Solicitud #{{ $request->id }}</h6>
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
                                <p class="mb-1">Cantidad esperada: {{ $request->quantityExpected }} ratas</p>
                                <small class="text-muted">Solicitado: {{ $request->created_at->format('d/m/Y') }}</small>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-muted">No tienes solicitudes de adopción.</p>
                        @endif
                        
                        <div class="mt-3">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#adoptModal">
                                <i class="bi bi-heart"></i> Nueva Solicitud de Adopción
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
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

    <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="reportModalLabel">Reportar Rata</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="reportForm">
                        @csrf
                        <input type="hidden" name="rat_id" id="reportRatId">
                        <div class="mb-3">
                            <label class="form-label">Rata</label>
                            <input type="text" class="form-control" id="reportRatName" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tipo de Reporte</label>
                            <select class="form-select" name="report_type" required>
                                <option value="">Seleccionar tipo</option>
                                <option value="sick">Enferma</option>
                                <option value="lost">Perdida</option>
                                <option value="behavior">Problema de comportamiento</option>
                                <option value="other">Otro</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control" name="description" rows="3" placeholder="Describe el problema..." required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" onclick="submitReport()">Enviar Reporte</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="renameModal" tabindex="-1" aria-labelledby="renameModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="renameModalLabel">Renombrar Rata</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="renameForm">
                        @csrf
                        <input type="hidden" name="rat_id" id="renameRatId">
                        <div class="mb-3">
                            <label class="form-label">Rata Actual</label>
                            <input type="text" class="form-control" id="renameRatName" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nuevo Nombre</label>
                            <input type="text" class="form-control" name="new_name" placeholder="Ingresa el nuevo nombre" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" onclick="submitRename()">Cambiar Nombre</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="adoptModal" tabindex="-1" aria-labelledby="adoptModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="adoptModalLabel">Solicitud de Adopción</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('user.adoption.submit') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Motivo de la adopción</label>
                                <textarea class="form-control" name="reason" rows="3" placeholder="¿Por qué quieres adoptar ratas?" required></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Experiencia previa</label>
                                <textarea class="form-control" name="experience" rows="3" placeholder="¿Has tenido ratas antes?" required></textarea>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Cantidad esperada</label>
                                <input type="number" class="form-control" name="quantityExpected" min="1" max="10" value="2" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">¿Pareja?</label>
                                <select class="form-select" name="couple" required>
                                    <option value="1">Sí</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">¿Sin retorno?</label>
                                <select class="form-select" name="noReturn" required>
                                    <option value="1">Sí</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">¿Puede pagar veterinario?</label>
                                <select class="form-select" name="canPayVet" required>
                                    <option value="1">Sí</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">¿Tiene otras mascotas?</label>
                                <select class="form-select" name="hasPets" required>
                                    <option value="1">Sí</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">¿Acepta seguimiento?</label>
                                <select class="form-select" name="followUp" required>
                                    <option value="1">Sí</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Foto de la jaula (opcional)</label>
                            <input type="file" class="form-control" name="imgUrl" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Información de otras mascotas (si aplica)</label>
                            <textarea class="form-control" name="petsInfo" rows="2" placeholder="Describe tus otras mascotas..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" onclick="submitAdoption()">Enviar Solicitud</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const reportModal = document.getElementById('reportModal');
        reportModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const ratId = button.getAttribute('data-rat-id');
            const ratName = button.getAttribute('data-rat-name');
            
            document.getElementById('reportRatId').value = ratId;
            document.getElementById('reportRatName').value = ratName;
            document.getElementById('reportModalLabel').textContent = 'Reportar: ' + ratName;
        });

        const renameModal = document.getElementById('renameModal');
        renameModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const ratId = button.getAttribute('data-rat-id');
            const ratName = button.getAttribute('data-rat-name');
            
            document.getElementById('renameRatId').value = ratId;
            document.getElementById('renameRatName').value = ratName;
            document.getElementById('renameModalLabel').textContent = 'Renombrar: ' + ratName;
        });

        function submitReport() {
            const form = document.getElementById('reportForm');
            const formData = new FormData(form);
            
            alert('Reporte enviado (función en desarrollo)');
            bootstrap.Modal.getInstance(reportModal).hide();
        }

        function submitRename() {
            const form = document.getElementById('renameForm');
            const formData = new FormData(form);
            
            alert('Nombre cambiado (función en desarrollo)');
            bootstrap.Modal.getInstance(renameModal).hide();
        }

        function submitAdoption() {
            const form = document.querySelector('#adoptModal form');
            const formData = new FormData(form);
            
            alert('Solicitud de adopción enviada (función en desarrollo)');
            bootstrap.Modal.getInstance(document.getElementById('adoptModal')).hide();
        }
    </script>
</body>
</html>