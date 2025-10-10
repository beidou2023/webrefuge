@extends('content')

@section('section')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="material-card p-4">
                <h2 class="section-title mb-4 text-center">Registro de Usuario</h2>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="firstName" class="form-label">Nombre</label>
                            <input type="text" name="firstName" class="form-control" value="{{ old('firstName') }}">
                            @error('firstName')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="lastName" class="form-label">Apellido</label>
                            <input type="text" name="lastName" class="form-control" value="{{ old('lastName') }}">
                            @error('lastName')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mt-3 row g-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" name="password" class="form-control">
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>

                    <div class="mt-3">
                        <label for="phone" class="form-label">Teléfono</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                        @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mt-3">
                        <label for="address" class="form-label">Dirección</label>
                        <textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea>
                        @error('address')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mt-4 d-grid gap-2">
                        <button type="submit" class="btn btn-success">Registrarse</button>
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary">¿Ya tienes cuenta? Inicia sesión</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const form = document.querySelector('form');
  
  const validations = {
    firstName: (value) => value.trim().length >= 3 && value.trim().length <= 40,
    lastName: (value) => value.trim().length >= 3 && value.trim().length <= 40,
    email: (value) => {
      const gmailRegex = /^[^\s@]+@gmail\.com$/;
      return gmailRegex.test(value) && value.length <= 75;
    },
    password: (value) => {
      const lengthOk = value.length >= 8 && value.length <= 20;
      const hasUpper = /[A-Z]/.test(value);
      const hasLower = /[a-z]/.test(value);
      const hasNumber = /[0-9]/.test(value);
      const hasSpecial = /[\W_]/.test(value);
      return lengthOk && hasUpper && hasLower && hasNumber && hasSpecial;
    },
    password_confirmation: (value) => value === form.password.value,
    phone: (value) => /^[67][0-9]{7}$/.test(value),
    address: (value) => value.trim().length >= 3 && value.trim().length <= 495
  };

  const errorMessages = {
    firstName: 'El nombre debe tener entre 3 y 40 caracteres.',
    lastName: 'El apellido debe tener entre 3 y 40 caracteres.',
    email: 'El correo debe ser un @gmail.com válido y menor a 75 caracteres.',
    password: 'La contraseña debe tener 8-20 caracteres, incluyendo mayúscula, minúscula, número y carácter especial.',
    password_confirmation: 'Las contraseñas no coinciden.',
    phone: 'El teléfono debe comenzar con 6 o 7 y tener 8 dígitos en total.',
    address: 'La dirección debe tener entre 3 y 495 caracteres.'
  };

  function validateField(field) {
    const value = field.value;
    const name = field.name;
    const valid = validations[name](value);
    const errorElId = name + 'Error';
    let errorEl = document.getElementById(errorElId);

    if (!errorEl) {
      errorEl = document.createElement('small');
      errorEl.id = errorElId;
      errorEl.className = 'text-danger';
      field.parentNode.appendChild(errorEl);
    }

    if (!valid) {
      errorEl.textContent = errorMessages[name];
      field.classList.add('is-invalid');
    } else {
      errorEl.textContent = '';
      field.classList.remove('is-invalid');
    }
    
    return valid;
  }

  Array.from(form.elements).forEach(input => {
    if (input.name && validations[input.name]) {
      input.addEventListener('input', () => validateField(input));
      input.addEventListener('blur', () => validateField(input));
    }
  });

  form.addEventListener('submit', e => {
    let allValid = true;
    Array.from(form.elements).forEach(input => {
      if (input.name && validations[input.name]) {
        const valid = validateField(input);
        if (!valid) allValid = false;
      }
    });
    if (!allValid) e.preventDefault();
  });
});
</script>
@endsection
