@extends('content')

@section('section')


<section class="myths-header py-5 text-white text-center" style="background: #CDB4DB;">
    <div class="container">
        <div class="row align-items-center min-vh-100">
            <div class="col-lg-8 mx-auto">
                <h1 class="display-4 fw-bold mb-4">Derribando Mitos</h1>
                <p class="lead">Descubre la verdad detrás de los conceptos erróneos más comunes sobre las ratas domésticas</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5" style="background: #F7F3F9;">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                @php
                    $myths = [
                        [
                            'icon' => 'fa-bacteria', 'color' => 'text-danger',
                            'title' => 'Las ratas son sucias y transmiten enfermedades',
                            'reality' => 'Las ratas domésticas son extremadamente limpias. Pasan horas acicalándose y cuidando su higiene personal.',
                            'facts' => [
                                'No son portadoras de la peste bubónica.',
                                'Pueden usar una caja de arena.',
                                'Organizan y mantienen limpio su espacio.'
                            ]
                        ],
                        [
                            'icon' => 'fa-tail', 'color' => 'text-warning',
                            'title' => 'Las colas de las ratas son desagradables y peligrosas',
                            'reality' => 'Las colas son fundamentales para su equilibrio y regulación térmica. Son herramientas evolutivas, no amenazas.',
                            'facts' => [
                                'Regulan temperatura corporal.',
                                'Ayudan a trepar y moverse con agilidad.',
                                'Son órganos táctiles sensibles.'
                            ]
                        ],
                        [
                            'icon' => 'fa-brain', 'color' => 'text-info',
                            'title' => 'Las ratas son animales simples y poco inteligentes',
                            'reality' => 'Las ratas son altamente inteligentes, con capacidad de aprendizaje, memoria avanzada y comportamientos complejos.',
                            'facts' => [
                                'Responden a su nombre.',
                                'Resuelven laberintos complejos.',
                                'Tienen empatía y excelente memoria.'
                            ]
                        ],
                        [
                            'icon' => 'fa-heart', 'color' => 'text-pink',
                            'title' => 'Las ratas son agresivas y muerden sin razón',
                            'reality' => 'Raramente muerden. Prefieren huir antes que confrontar, y responden con cariño cuando se las cuida correctamente.',
                            'facts' => [
                                'Dan señales antes de morder.',
                                'Forman lazos afectivos con humanos.',
                                'Pueden lamer como muestra de afecto.'
                            ]
                        ],
                        [
                            'icon' => 'fa-hourglass-half', 'color' => 'text-secondary',
                            'title' => 'Viven muy poco y no vale la pena encariñarse',
                            'reality' => 'Viven 2-3 años, pero su intensidad emocional hace cada momento especial y lleno de aprendizajes.',
                            'facts' => [
                                'Vivir su ciclo completo enseña resiliencia.',
                                'Crean recuerdos significativos cada día.',
                                'Su cariño compensa su corta vida.'
                            ]
                        ]
                    ];
                @endphp

                @foreach($myths as $myth)
                <div class="myth-card mb-5 p-4 rounded shadow-sm bg-white">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center">
                            <i class="fas {{ $myth['icon'] }} fa-3x {{ $myth['color'] }}"></i>
                        </div>
                        <div class="col-md-10">
                            <h3 class="myth-title">Mito: {{ $myth['title'] }}</h3>
                            <div class="truth-content mt-3">
                                <h5 class="text-success">Realidad:</h5>
                                <p>{{ $myth['reality'] }}</p>
                                <ul class="fact-list">
                                    @foreach($myth['facts'] as $fact)
                                        <li>{{ $fact }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>
</section>

<section class="py-5" style="background-color: #E3D5CA;">
    <div class="container">
        <h2 class="text-center mb-5">Datos Científicos Interesantes</h2>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="science-card bg-white rounded p-4 shadow-sm h-100">
                    <h4>Inteligencia Emocional</h4>
                    <p>Las ratas muestran empatía y ayudan a compañeros en apuros, incluso sin recompensa.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="science-card bg-white rounded p-4 shadow-sm h-100">
                    <h4>Capacidad de Razonamiento</h4>
                    <p>Pueden comprender relaciones causa-efecto y hacer inferencias complejas.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="science-card bg-white rounded p-4 shadow-sm h-100">
                    <h4>Memoria Superior</h4>
                    <p>Recuerdan rutas complejas durante meses gracias a su aguda memoria espacial.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="science-card bg-white rounded p-4 shadow-sm h-100">
                    <h4>Comunicación Avanzada</h4>
                    <p>Se comunican con ultrasonidos para expresar alegría, miedo o curiosidad.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
