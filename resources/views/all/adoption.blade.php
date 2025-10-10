@extends('content')

@section('section')

<section class="hero-section text-center">
    <div class="container py-5">
        <h1 class="display-5 fw-bold text-white">Adopción de Ratas Especiales</h1>
        <p class="lead text-white-50 mb-0">Conoce a quienes más necesitan un hogar lleno de amor</p>
    </div>
</section>

<div class="container py-5">
    <h2 class="section-title text-center mb-4">Disponibles para adopción</h2>
    <p class="text-center text-muted mb-5">Selecciona una tarjeta para conocer más detalles</p>

    @if($specialRats->count() > 0)
        <div class="row">
            @foreach($specialRats as $rat)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="myth-card h-100 cursor-pointer" data-bs-toggle="modal" data-bs-target="#ratModal"
                         onclick="showRatDetails(
                            '{{ $rat->id }}',
                            '{{ addslashes($rat->name) }}',
                            `{{ addslashes($rat->description) }}`,
                            '{{ $rat->imgUrl }}',
                            '{{ $rat->sex }}',
                            '{{ $rat->status }}',
                            '{{ $rat->created_at }}',
                            '{{ addslashes($rat->refuge->name) }}',
                            '{{ addslashes($rat->refuge->address) }}'
                         )">
                        <div class="position-relative">
                            <img src="{{ $rat->imgUrl }}" class="card-img-top rounded-top" alt="{{ $rat->name }}" style="height: 220px; object-fit: cover;">
                            
                            <span class="badge sex-badge position-absolute top-0 start-0 m-2 {{ $rat->sex == 'M' ? 'bg-info' : 'bg-danger' }}">
                                {{ $rat->sex == 'M' ? '♂ Macho' : '♀ Hembra' }}
                            </span>
                            
                            <span class="badge status-badge position-absolute top-0 end-0 m-2 {{ $rat->status == \App\Models\Specialrat::STATUS_ACTIVE ? 'bg-success' : 'bg-warning' }}">
                                {{ $rat->status == \App\Models\Specialrat::STATUS_ACTIVE ? 'Disponible' : 'En proceso' }}
                            </span>
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $rat->name }}</h5>
                            <p class="text-muted mb-1"><strong>Refugio:</strong> {{ $rat->refuge->name }}</p>
                            <p class="mb-3">{{ Str::limit($rat->description, 100) }}</p>

                            <div class="mt-auto text-end">
                                <span class="btn btn-outline-primary btn-sm">Ver detalles</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <div class="alert alert-info">
                <h4 class="alert-heading">Sin ratas especiales disponibles</h4>
                <p class="mb-0">Actualmente no hay ratas especiales en adopción. Por favor, vuelve a visitar pronto.</p>
            </div>
        </div>
    @endif
</div>

<!-- Modal de Detalles -->
<div class="modal fade" id="ratModal" tabindex="-1" aria-labelledby="ratModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title section-title" id="ratModalLabel">Detalles de la Rata</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <img id="modalRatImage" src="" class="img-fluid rounded shadow-sm" alt="">
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h3 id="modalRatName" class="mb-0"></h3>
                            <div>
                                <span id="modalRatSex" class="badge me-1"></span>
                                <span id="modalRatStatus" class="badge"></span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <h5 class="mb-1">Sobre <span id="modalRatNameTitle"></span></h5>
                            <p id="modalRatDescription" class="text-muted mb-0"></p>
                        </div>

                        <div class="material-card mt-3">
                            <h6 class="mb-2">Refugio</h6>
                            <p class="mb-1"><strong>Nombre:</strong> <span id="modalRefugeName"></span></p>
                            <p class="mb-1"><strong>Dirección:</strong> <span id="modalRefugeAddress"></span></p>
                            <p class="mb-0"><strong>Estado:</strong> <span class="text-success">Activo</span></p>
                        </div>

                        <div class="mt-3">
                            <small class="text-muted" id="modalRatDate"></small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="adoptButton">Solicitar Adopción</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showRatDetails(id, name, description, imgUrl, sex, status, createdAt, refugeName, refugeAddress) {
        const img = document.getElementById('modalRatImage');
        img.src = imgUrl;
        img.alt = name;
        img.onerror = function () {
            this.src = 'https://via.placeholder.com/500x400/6c757d/ffffff?text=Imagen+no+disponible';
        };

        document.getElementById('modalRatName').textContent = name;
        document.getElementById('modalRatNameTitle').textContent = name;
        document.getElementById('modalRatDescription').textContent = description;
        document.getElementById('modalRefugeName').textContent = refugeName;
        document.getElementById('modalRefugeAddress').textContent = refugeAddress;

        const sexBadge = document.getElementById('modalRatSex');
        sexBadge.textContent = sex === 'M' ? '♂ Macho' : '♀ Hembra';
        sexBadge.className = `badge ${sex === 'M' ? 'bg-info' : 'bg-danger'} me-1`;

        const statusBadge = document.getElementById('modalRatStatus');
        const isActive = parseInt(status) === 1;
        statusBadge.textContent = isActive ? 'Disponible' : 'En proceso';
        statusBadge.className = `badge ${isActive ? 'bg-success' : 'bg-warning'}`;

        const date = new Date(createdAt);
        document.getElementById('modalRatDate').textContent = 'Registrado el: ' + date.toLocaleDateString('es-ES');

        const adoptBtn = document.getElementById('adoptButton');
        if (isActive) {
            adoptBtn.style.display = 'inline-block';
            adoptBtn.onclick = function () {
                window.location.href = `/adoption`;
            };
        } else {
            adoptBtn.style.display = 'none';
        }
    }
</script>

@endsection
