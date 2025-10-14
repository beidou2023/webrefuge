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
                            '{{ addslashes($rat->refuge->address) }}',
                            '{{ $rat->id }}',
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
@auth
    @if(auth()->user()->role == 1)
        @php
            $adoptionRequest = new App\Models\AdoptionRequest();
            $hasPending = $adoptionRequest->havePending(auth()->id());
        @endphp
        
        @if($hasPending)
            <button type="button" class="btn btn-warning" disabled>Ya tienes una solicitud pendiente</button>
            <small class="text-muted d-block mt-1">Espere a que se procese su solicitud actual</small>
        @else
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#specialAdoptModal">
                    <i class="bi bi-star-fill"></i>Adopción Rata Especial
                </button>
            </div>
        @endif
    @else
        <button type="button" class="btn btn-secondary" disabled>Solicitar Adopción</button>
        <small class="text-muted d-block mt-1">No disponible para su rol</small>
    @endif
@else
    <button type="button" class="btn btn-secondary" disabled>Solicitar Adopción</button>
    <div class="mt-1">
        <small class="text-warning">Primero <a href="{{ route('register') }}" class="text-primary">créese una cuenta</a></small>
    </div>
@endauth
                
            </div>
        </div>
    </div>
</div>

<script>
let currentSpecialRatId = null;

function showRatDetails(id, name, description, imgUrl, sex, status, createdAt, refugeName, refugeAddress) {
    currentSpecialRatId = id;
    
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

    updateSpecialAdoptModal(id, name);
}

function updateSpecialAdoptModal(ratId, ratName) {
    const hiddenInput = document.getElementById('specialRatIdInput');
    if (hiddenInput) {
        hiddenInput.value = ratId;
    }
    
    const ratInfoElement = document.getElementById('specialRatInfo');
    if (ratInfoElement) {
        ratInfoElement.innerHTML = `
            <i class="bi bi-info-circle-fill"></i>
            <strong>Rata Especial:</strong> ${ratName}
            <span class="badge bg-warning text-dark ms-2">ID: ${ratId}</span>
        `;
    }
}
</script>

<div class="modal fade" id="specialAdoptModal" tabindex="-1" aria-labelledby="specialAdoptModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="specialAdoptModalLabel">
                    <i class="bi bi-star-fill"></i> Solicitud de Adopción Especial
                </h5>
                
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('adoption.special.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <input type="hidden" name="idSpecialRat" id="specialRatIdInput" value="">

                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <strong>Adopción Especial:</strong> Esta solicitud es para una rata con necesidades específicas que requiere cuidados especiales.
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="specialImgUrl" class="form-label">Imagen de su jaula *</label>
                                <input type="file" class="form-control @error('imgUrl') is-invalid @enderror" id="specialImgUrl" name="imgUrl" accept="image/*" required>
                                @error('imgUrl')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Muestre el hábitat preparado para necesidades especiales</div>
                            </div>

                            <div class="mb-3">
                                <label for="specialReason" class="form-label">Razones para adoptar *</label>
                                <textarea class="form-control @error('reason') is-invalid @enderror" id="specialReason" name="reason" rows="2" required>{{ old('reason') }}</textarea>
                                @error('reason')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Mínimo 10 caracteres</small>
                            </div>

                            <div class="mb-3">
                                <label for="specialExperience" class="form-label">Experiencia con mascotas *</label>
                                <textarea class="form-control @error('experience') is-invalid @enderror" id="specialExperience" name="experience" rows="2" required>{{ old('experience') }}</textarea>
                                @error('experience')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Mínimo 10 caracteres</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="specialContactTravel" class="form-label">Contacto en viajes *</label>
                                <input type="text" class="form-control @error('contactTravel') is-invalid @enderror" id="specialContactTravel" name="contactTravel" value="{{ old('contactTravel') }}" required>
                                @error('contactTravel')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="specialContactReturn" class="form-label">Contacto para devolución *</label>
                                <input type="text" class="form-control @error('contactReturn') is-invalid @enderror" id="specialContactReturn" name="contactReturn" value="{{ old('contactReturn') }}" required>
                                @error('contactReturn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Compromisos *</label>
                                <div class="border rounded p-3 bg-light">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input @error('noReturn') is-invalid @enderror" type="checkbox" id="specialNoReturn" name="noReturn" value="1" {{ old('noReturn') ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="specialNoReturn">No devolución</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input @error('care') is-invalid @enderror" type="checkbox" id="specialCare" name="care" value="1" {{ old('care') ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="specialCare">Cuidado adecuado</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input @error('followUp') is-invalid @enderror" type="checkbox" id="specialFollowUp" name="followUp" value="1" {{ old('followUp') ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="specialFollowUp">Seguimiento</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input @error('canPayVet') is-invalid @enderror" type="checkbox" id="specialCanPayVet" name="canPayVet" value="1" {{ old('canPayVet') ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="specialCanPayVet">Gastos veterinarios</label>
                                    </div>
                                </div>
                                @error('noReturn')<div class="text-danger small">{{ $message }}</div>@enderror
                                @error('care')<div class="text-danger small">{{ $message }}</div>@enderror
                                @error('followUp')<div class="text-danger small">{{ $message }}</div>@enderror
                                @error('canPayVet')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">¿Tiene mascotas? *</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input @error('hasPets') is-invalid @enderror" type="radio" name="hasPets" id="specialHasPetsYes" value="1" {{ old('hasPets') == '1' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="specialHasPetsYes">Sí</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input @error('hasPets') is-invalid @enderror" type="radio" name="hasPets" id="specialHasPetsNo" value="0" {{ old('hasPets') == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="specialHasPetsNo">No</label>
                                    </div>
                                </div>
                                @error('hasPets')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3" id="specialPetsInfoSection" style="display: {{ old('hasPets') == '1' ? 'block' : 'none' }};">
                                <label for="specialPetsInfo" class="form-label">Describa el ambiente de sus mascotas</label>
                                <textarea class="form-control @error('petsInfo') is-invalid @enderror" id="specialPetsInfo" name="petsInfo" rows="2">{{ old('petsInfo') }}</textarea>
                                @error('petsInfo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-star-fill"></i> Enviar Solicitud Especial
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const specialHasPetsYes = document.getElementById('specialHasPetsYes');
    const specialHasPetsNo = document.getElementById('specialHasPetsNo');
    const specialPetsInfoSection = document.getElementById('specialPetsInfoSection');
    const specialPetsInfoField = document.getElementById('specialPetsInfo');

    function toggleSpecialPetsInfo() {
        if (specialHasPetsYes.checked) {
            specialPetsInfoSection.style.display = 'block';
            specialPetsInfoField.required = true;
        } else {
            specialPetsInfoSection.style.display = 'none';
            specialPetsInfoField.required = false;
        }
    }

    if (specialHasPetsYes && specialHasPetsNo) {
        specialHasPetsYes.addEventListener('change', toggleSpecialPetsInfo);
        specialHasPetsNo.addEventListener('change', toggleSpecialPetsInfo);
    }

    @if($errors->any() && request()->routeIs('adoption.special.store'))
        const modal = new bootstrap.Modal(document.getElementById('specialAdoptModal'));
        modal.show();
    @endif
});
</script>

@endsection
