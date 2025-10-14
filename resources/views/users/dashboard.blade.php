@extends('content')

@section('section')
<div class="container my-5">

    {{-- Saludo y resumen --}}
    <div class="text-center mb-5">
        <h1 class="fw-bold" style="color: var(--section-title)">Bienvenido, {{ $user->firstName }}</h1>
        <p class="text-muted">Aquí puedes ver tu información personal, tus adopciones y solicitudes.</p>
    </div>
    @if(session('successRequest'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle-fill"></i> {{ session('successRequest') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('successEdit'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> {{ session('successEdit') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('successEditRat'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> {{ session('successEditRat') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    

    {{-- Información personal y estadísticas --}}
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card feature-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h5 class="card-title mb-0"><i class="bi bi-person-circle"></i> Mi Información</h5>
                        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                            <i class="bi bi-pencil"></i> Editar
                        </button>
                    </div>
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
        <div class="col-md-12">
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
                        @php
                            $adoptionRequest = new App\Models\AdoptionRequest();
                            $hasPending = $adoptionRequest->havePending(auth()->id());
                        @endphp
                        
                        @if($hasPending)
                            <button type="button" class="btn btn-warning" disabled>Ya tienes una solicitud pendiente</button>
                            <small class="text-muted d-block mt-1">Espere a que se procese su solicitud actual</small>
                        @else
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#adoptModal">
                            <i class="bi bi-heart"></i> Nueva Solicitud
                        </button>
                        @endif
                        
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


<div class="modal fade" id="adoptModal" tabindex="-1" aria-labelledby="adoptModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="adoptModalLabel">
                    <i class="bi bi-heart-fill"></i> Solicitud de Adopción
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('adoption.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
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
                                <label for="imgUrl" class="form-label">Imagen de su jaula *</label>
                                <input type="file" class="form-control @error('imgUrl') is-invalid @enderror" id="imgUrl" name="imgUrl" accept="image/*" required>
                                @error('imgUrl')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Muestre el hábitat preparado</div>
                            </div>

                            <div class="mb-3">
                                <label for="reason" class="form-label">Razones para adoptar *</label>
                                <textarea class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason" rows="2" required>{{ old('reason') }}</textarea>
                                @error('reason')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Mínimo 10 caracteres</small>
                            </div>

                            <div class="mb-3">
                                <label for="experience" class="form-label">Experiencia con mascotas *</label>
                                <textarea class="form-control @error('experience') is-invalid @enderror" id="experience" name="experience" rows="2" required>{{ old('experience') }}</textarea>
                                @error('experience')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Mínimo 10 caracteres</small>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="quantityExpected" class="form-label">Cantidad *</label>
                                        <select class="form-select @error('quantityExpected') is-invalid @enderror" id="quantityExpected" name="quantityExpected" required>
                                            <option value="">Seleccione</option>
                                            <option value="1" {{ old('quantityExpected') == '1' ? 'selected' : '' }}>1</option>
                                            <option value="2" {{ old('quantityExpected') == '2' ? 'selected' : '' }}>2</option>
                                            <option value="3" {{ old('quantityExpected') == '3' ? 'selected' : '' }}>3</option>
                                            <option value="4" {{ old('quantityExpected') == '4' ? 'selected' : '' }}>4</option>
                                            <option value="5" {{ old('quantityExpected') == '5' ? 'selected' : '' }}>5+</option>
                                        </select>
                                        @error('quantityExpected')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tipo *</label>
                                        <select class="form-select @error('couple') is-invalid @enderror" name="couple" required>
                                            <option value="">Seleccione</option>
                                            <option value="1" {{ old('couple') == '1' ? 'selected' : '' }}>Pareja</option>
                                            <option value="0" {{ old('couple') == '0' ? 'selected' : '' }}>Solo machos</option>
                                            <option value="2" {{ old('couple') == '2' ? 'selected' : '' }}>Solo hembras</option>
                                        </select>
                                        @error('couple')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="contactTravel" class="form-label">Contacto en viajes *</label>
                                <input type="text" class="form-control @error('contactTravel') is-invalid @enderror" id="contactTravel" name="contactTravel" value="{{ old('contactTravel') }}" required>
                                @error('contactTravel')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="contactReturn" class="form-label">Contacto para devolución *</label>
                                <input type="text" class="form-control @error('contactReturn') is-invalid @enderror" id="contactReturn" name="contactReturn" value="{{ old('contactReturn') }}" required>
                                @error('contactReturn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Compromisos *</label>
                                <div class="border rounded p-3 bg-light">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input @error('noReturn') is-invalid @enderror" type="checkbox" id="noReturn" name="noReturn" value="1" {{ old('noReturn') ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="noReturn">No devolución</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input @error('care') is-invalid @enderror" type="checkbox" id="care" name="care" value="1" {{ old('care') ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="care">Cuidado adecuado</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input @error('followUp') is-invalid @enderror" type="checkbox" id="followUp" name="followUp" value="1" {{ old('followUp') ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="followUp">Seguimiento</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input @error('canPayVet') is-invalid @enderror" type="checkbox" id="canPayVet" name="canPayVet" value="1" {{ old('canPayVet') ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="canPayVet">Gastos veterinarios</label>
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
                                        <input class="form-check-input @error('hasPets') is-invalid @enderror" type="radio" name="hasPets" id="hasPetsYes" value="1" {{ old('hasPets') == '1' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="hasPetsYes">Sí</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input @error('hasPets') is-invalid @enderror" type="radio" name="hasPets" id="hasPetsNo" value="0" {{ old('hasPets') == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="hasPetsNo">No</label>
                                    </div>
                                </div>
                                @error('hasPets')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3" id="petsInfoSection" style="display: {{ old('hasPets') == '1' ? 'block' : 'none' }};">
                                <label for="petsInfo" class="form-label">Describa el ambiente de sus mascotas</label>
                                <textarea class="form-control @error('petsInfo') is-invalid @enderror" id="petsInfo" name="petsInfo" rows="2">{{ old('petsInfo') }}</textarea>
                                @error('petsInfo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-send"></i> Enviar Solicitud
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const hasPetsYes = document.getElementById('hasPetsYes');
    const hasPetsNo = document.getElementById('hasPetsNo');
    const petsInfoSection = document.getElementById('petsInfoSection');
    const petsInfoField = document.getElementById('petsInfo');

    function togglePetsInfo() {
        if (hasPetsYes.checked) {
            petsInfoSection.style.display = 'block';
            petsInfoField.required = true;
        } else {
            petsInfoSection.style.display = 'none';
            petsInfoField.required = false;
        }
    }

    hasPetsYes.addEventListener('change', togglePetsInfo);
    hasPetsNo.addEventListener('change', togglePetsInfo);

    @if($errors->any() && request()->routeIs('adoption.store'))
        const modal = new bootstrap.Modal(document.getElementById('adoptModal'));
        modal.show();
    @endif
});
</script>


<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editProfileModalLabel">
                    <i class="bi bi-person-gear"></i> Editar Mi Perfil
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="modal-body">
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
                                <label for="firstName" class="form-label">Nombre *</label>
                                <input type="text" class="form-control @error('firstName') is-invalid @enderror" 
                                       id="firstName" name="firstName" value="{{ old('firstName', $user->firstName) }}" required>
                                @error('firstName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="lastName" class="form-label">Apellido *</label>
                                <input type="text" class="form-control @error('lastName') is-invalid @enderror" 
                                       id="lastName" name="lastName" value="{{ old('lastName', $user->lastName) }}" required>
                                @error('lastName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control bg-light" 
                            id="email" value="{{ $user->email }}" readonly disabled>
                        <div class="form-text">El email no se puede modificar</div>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Teléfono</label>
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" value="{{ old('phone', $user->phone) }}" 
                               placeholder="Ej: +34 123 456 789">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Dirección</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                  id="address" name="address" rows="3" 
                                  placeholder="Ingrese su dirección completa">{{ old('address', $user->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="card mt-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Cambiar Contraseña (Opcional)</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Contraseña Actual</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                       id="current_password" name="current_password">
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Nueva Contraseña</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-0">
                                <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="renameModal" tabindex="-1" aria-labelledby="renameModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="renameModalLabel">
                    <i class="bi bi-pencil"></i> Renombrar Rata
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('rats.rename') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="rat_id" id="renameRatId">
                
                <div class="modal-body">
                    @if($errors->any() && session('open_rename_modal'))
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        <strong>Rata:</strong> <span id="currentRatName"></span>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Nuevo Nombre *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" 
                               placeholder="Ingresa el nuevo nombre" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="color" class="form-label">Color</label>
                        <input type="text" class="form-control @error('color') is-invalid @enderror" 
                               id="color" name="color" value="{{ old('color') }}" 
                               placeholder="Ej: Blanco, Gris, Negro, Marrón">
                        @error('color')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="sex" class="form-label">Sexo *</label>
                        <select class="form-select @error('sex') is-invalid @enderror" id="sex" name="sex" required>
                            <option value="">Selecciona el sexo</option>
                            <option value="M" {{ old('sex') == 'M' ? 'selected' : '' }}>♂ Macho</option>
                            <option value="F" {{ old('sex') == 'F' ? 'selected' : '' }}>♀ Hembra</option>
                        </select>
                        @error('sex')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="ageMonths" class="form-label">Edad (meses)</label>
                        <input type="number" class="form-control @error('ageMonths') is-invalid @enderror" 
                               id="ageMonths" name="ageMonths" value="{{ old('ageMonths') }}" 
                               min="1" max="36" placeholder="Ej: 6">
                        @error('ageMonths')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Edad aproximada en meses (1-36)</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const renameModal = document.getElementById('renameModal');
    if (renameModal) {
        renameModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const ratId = button.getAttribute('data-rat-id');
            const ratName = button.getAttribute('data-rat-name');
            
            document.getElementById('renameRatId').value = ratId;
            document.getElementById('currentRatName').textContent = ratName;
            
            loadRatData(ratId);
        });
    }

    function loadRatData(ratId) {
        fetch(`/api/rats/${ratId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('name').value = data.name || '';
                document.getElementById('color').value = data.color || '';
                document.getElementById('sex').value = data.sex || '';
                document.getElementById('ageMonths').value = data.age_months || '';
            })
            .catch(error => {
                console.error('Error loading rat data:', error);
            });
    }

    @if(session('open_rename_modal') || ($errors->any() && request()->routeIs('rats.rename')))
        const modal = new bootstrap.Modal(document.getElementById('renameModal'));
        modal.show();
        
        @if(session('rename_rat_id'))
            document.getElementById('renameRatId').value = '{{ session("rename_rat_id") }}';
            loadRatData('{{ session("rename_rat_id") }}');
        @endif
    @endif
});
</script>

<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="reportModalLabel">
                    <i class="bi bi-flag"></i> Reportar Rata
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('rats.report') }}" method="POST">
                @csrf
                <input type="hidden" name="rat_id" id="reportRatId">
                
                <div class="modal-body">
                    @if($errors->any() && session('open_report_modal'))
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        <strong>Rata a reportar:</strong> <span id="reportRatName"></span>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Tipo de Reporte *</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="">Selecciona el tipo de reporte</option>
                            <option value="2" {{ old('status') == '2' ? 'selected' : '' }}>🐭 Enferma</option>
                            <option value="3" {{ old('status') == '3' ? 'selected' : '' }}>🔍 Perdida</option>
                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>❌ Otro problema</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="comment" class="form-label">Descripción del problema *</label>
                        <textarea class="form-control @error('comment') is-invalid @enderror" 
                                  id="comment" name="comment" rows="4" 
                                  placeholder="Describe detalladamente el problema o situación..."
                                  required>{{ old('comment') }}</textarea>
                        @error('comment')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Sé específico sobre los síntomas, cuándo comenzó el problema, etc.
                        </div>
                    </div>

                    <div class="alert alert-warning">
                        <h6><i class="bi bi-exclamation-triangle"></i> Información importante</h6>
                        <small class="mb-0">
                            • Los reportes serán revisados por nuestro equipo<br>
                            • Nos pondremos en contacto contigo si necesitamos más información<br>
                            • Para emergencias veterinarias, contacta directamente a tu veterinario
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-send"></i> Enviar Reporte
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const reportModal = document.getElementById('reportModal');
    if (reportModal) {
        reportModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const ratId = button.getAttribute('data-rat-id');
            const ratName = button.getAttribute('data-rat-name');
            
            document.getElementById('reportRatId').value = ratId;
            document.getElementById('reportRatName').textContent = ratName;
        });
    }

    @if(session('open_report_modal') || ($errors->any() && request()->routeIs('rats.report')))
        const modal = new bootstrap.Modal(document.getElementById('reportModal'));
        modal.show();
        
        @if(session('report_rat_id'))
            document.getElementById('reportRatId').value = '{{ session("report_rat_id") }}';
        @endif
    @endif

    const statusSelect = document.getElementById('status');
    const commentTextarea = document.getElementById('comment');
    
    if (statusSelect && commentTextarea) {
        statusSelect.addEventListener('change', function() {
            const placeholders = {
                '2': 'Describe los síntomas, cuándo comenzaron, comportamiento observado, cambios en alimentación, etc...',
                '3': 'Describe cuándo y dónde se perdió, última vez que la viste, lugares donde suele estar, características distintivas...',
                '0': 'Describe el problema o situación que quieres reportar...'
            };
            commentTextarea.placeholder = placeholders[this.value] || 'Describe detalladamente el problema o situación...';
        });
    }
});
</script>

@endsection
