@extends('content')

@section('section')

<section class="hero-section py-5">
    <div class="container">
        <div class="row align-items-center min-vh-100">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Bienvenido a MyRefuge</h1>
                <p class="lead mb-4">Un santuario dedicado al rescate, cuidado y adopción responsable de ratas domésticas. Descubre la inteligencia y cariño que estas maravillosas criaturas pueden ofrecer.</p>
                <div class="hero-buttons">
                    <a href="#about" class="btn btn-primary btn-lg me-3">Conócenos</a>
                    <a href="{{ route('cares') }}" class="btn btn-outline-light btn-lg">Aprender Cuidados</a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="{{ asset('images/example.jpg') }}" alt="Rata doméstica" class="hero-image img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>

<section id="about" class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="section-title">¿Por qué elegir ratas como mascotas?</h2>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card text-center">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-brain fa-3x text-primary"></i>
                    </div>
                    <h4>Inteligencia Excepcional</h4>
                    <p class="text-muted">Las ratas son consideradas uno de los roedores más inteligentes. Pueden aprender trucos, reconocer su nombre y resolver problemas complejos.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card text-center">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-heart fa-3x text-success"></i>
                    </div>
                    <h4>Compañeras Cariñosas</h4>
                    <p class="text-muted">Desarrollan fuertes vínculos con sus dueños, disfrutan de las caricias y buscan activamente la interacción humana.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card text-center">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-leaf fa-3x text-info"></i>
                    </div>
                    <h4>Ecológicamente Eficientes</h4>
                    <p class="text-muted">Requieren menos espacio y recursos que otras mascotas, haciendo que su mantenimiento sea más sostenible y económico.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3">
                <div class="stat-item">
                    <h3 class="display-4 fw-bold">500+</h3>
                    <p class="text-muted">Ratitas rescatadas</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-item">
                    <h3 class="display-4 fw-bold">300+</h3>
                    <p class="text-muted">Adopciones exitosas</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-item">
                    <h3 class="display-4 fw-bold">98%</h3>
                    <p class="text-muted">Tasa de éxito en rehabilitación</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-item">
                    <h3 class="display-4 fw-bold">1</h3>
                    <p class="text-muted">Año de experiencia</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
