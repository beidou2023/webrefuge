@extends('content')

@section('section')

<section class="cares-header hero-section">
    <div class="container">
        <div class="row align-items-center min-vh-100">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold">Guía Completa de Cuidados</h1>
                <p class="lead">Aprende todo lo necesario para proporcionar una vida feliz y saludable a tus compañeras ratas</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">

                <div class="care-section mb-5">
                    <h2 class="section-title mb-4"><i class="fas fa-house fa-fw me-2"></i> Alojamiento Ideal</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="care-point">
                                <h5>La Jaula Perfecta</h5>
                                <ul>
                                    <li><strong>Tamaño mínimo:</strong> 60x40x60cm para 2-3 ratas</li>
                                    <li><strong>Material:</strong> Jaulas de barrotes metálicos con base sólida</li>
                                    <li><strong>Espaciado:</strong> Máximo 1.5cm entre barrotes</li>
                                    <li><strong>Pisos:</strong> Múltiples niveles con rampas seguras</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="care-point">
                                <h5>Ubicación y Ambiente</h5>
                                <ul>
                                    <li>Lejos de corrientes de aire directas</li>
                                    <li>Evitar luz solar directa prolongada</li>
                                    <li>Temperatura constante (18-24°C)</li>
                                    <li>Zona de actividad familiar pero sin estrés</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="care-section mb-5">
                    <h2 class="section-title mb-4"><i class="fas fa-bed fa-fw me-2"></i> Lecho y Sustrato</h2>
                    <div class="alert alert-info">
                        <strong>Importante:</strong> Evitar siempre sustratos de pino o cedro por sus fenoles tóxicos.
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="material-card">
                                <h5><i class="fas fa-circle-check text-success me-2"></i> Recomendados</h5>
                                <ul>
                                    <li>Pellets de papel reciclado</li>
                                    <li>Maíz molido</li>
                                    <li>Pulpa de celulosa</li>
                                    <li>Tela polar para hamacas</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="material-card">
                                <h5><i class="fas fa-triangle-exclamation text-warning me-2"></i> Aceptables</h5>
                                <ul>
                                    <li>Viruta de álamo</li>
                                    <li>Paja de trigo</li>
                                    <li>Alfalfa prensada</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="material-card">
                                <h5><i class="fas fa-circle-xmark text-danger me-2"></i> Evitar</h5>
                                <ul>
                                    <li>Viruta de pino/cedro</li>
                                    <li>Arena para gatos</li>
                                    <li>Periódico con tinta</li>
                                    <li>Serrín fino</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="care-section mb-5">
                    <h2 class="section-title mb-4"><i class="fas fa-apple-alt fa-fw me-2"></i> Nutrición Balanceada</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="nutrition-card">
                                <h5>Alimentos Base (80%)</h5>
                                <ul>
                                    <li>Pienso específico para ratas</li>
                                    <li>Mezcla de semillas y granos</li>
                                    <li>Cereales integrales</li>
                                    <li>Pellets de calidad</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="nutrition-card">
                                <h5>Frutas y Verduras (20%)</h5>
                                <ul>
                                    <li>Manzana, plátano, pera</li>
                                    <li>Zanahoria, brócoli, guisantes</li>
                                    <li>Hojas verdes oscuras</li>
                                    <li>Calabaza, pepino</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-warning mt-3">
                        <strong>Alimentos prohibidos:</strong> Chocolate, cafeína, cítricos en exceso, alimentos procesados, dulces.
                    </div>
                </div>

                <div class="care-section mb-5">
                    <h2 class="section-title mb-4"><i class="fas fa-capsules fa-fw me-2"></i> Salud y Prevención</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="health-card">
                                <h5>Señales de Salud</h5>
                                <ul>
                                    <li>Ojos brillantes y sin secreción</li>
                                    <li>Pelaje limpio y uniforme</li>
                                    <li>Actividad normal y curiosidad</li>
                                    <li>Respiración silenciosa</li>
                                    <li>Peso estable</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="health-card">
                                <h5>Señales de Alerta</h5>
                                <ul>
                                    <li>Estornudos frecuentes</li>
                                    <li>Sonidos respiratorios</li>
                                    <li>Letargo prolongado</li>
                                    <li>Pérdida de apetito</li>
                                    <li>Cambios en heces/orina</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="care-section mb-5">
                    <h2 class="section-title mb-4"><i class="fas fa-bullseye fa-fw me-2"></i> Enriquecimiento Ambiental</h2>
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="enrichment-card text-center">
                                <div class="enrichment-icon mb-2"><i class="fas fa-home fa-2x"></i></div>
                                <h5>Estructuras</h5>
                                <p>Casitas, túneles, hamacas múltiples, plataformas a diferentes alturas</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="enrichment-card text-center">
                                <div class="enrichment-icon mb-2"><i class="fas fa-puzzle-piece fa-2x"></i></div>
                                <h5>Juguetes Cognitivos</h5>
                                <p>Rompecabezas de comida, laberintos, juguetes dispensadores</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="enrichment-card text-center">
                                <div class="enrichment-icon mb-2"><i class="fas fa-running fa-2x"></i></div>
                                <h5>Ejercicio</h5>
                                <p>Ruedas seguras (sin barrotes), áreas de exploración supervisada</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="care-section">
                    <h2 class="section-title mb-4"><i class="fas fa-users fa-fw me-2"></i> Vida Social</h2>
                    <div class="social-guide">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="social-point">
                                    <h5>Compañerismo Esencial</h5>
                                    <p>Las ratas son animales profundamente sociales que <strong>nunca</strong> deben vivir solas. La soledad causa depresión, estrés y problemas de salud.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="social-point">
                                    <h5>Grupos Ideales</h5>
                                    <p>Mínimo 2 ratas, preferiblemente 3-4. Grupos del mismo sexo o esterilizados. Introducciones graduales y supervisadas.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="emergency-card p-4">
            <h3 class="section-title mb-3"><i class="fas fa-triangle-exclamation fa-fw me-2"></i> Cuidados de Emergencia</h3>
            <p>Ten siempre el contacto de un veterinario especializado en animales exóticos. Las ratas pueden enfermar rápidamente, y el tiempo es crucial.</p>
            <ul>
                <li>Veterinario 24h en tu zona</li>
                <li>Kit básico de primeros auxilios</li>
                <li>Termómetro, jeringas sin aguja, mantas térmicas</li>
            </ul>
        </div>
    </div>
</section>

@endsection
