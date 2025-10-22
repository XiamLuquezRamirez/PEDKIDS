<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PEDKIDS - Asignaturas {{ $grado }}° Grado</title>
    <link rel="stylesheet" href="{{ asset('css/asignaturas.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <!-- Patrones educativos animados en el fondo -->
    <div class="educational-patterns">
        <div class="pattern-item">📚</div>
        <div class="pattern-item">🔢</div>
        <div class="pattern-item">✏️</div>
        <div class="pattern-item">🎨</div>
        <div class="pattern-item">🔬</div>
        <div class="pattern-item">🌍</div>
        <div class="pattern-item">🎵</div>
        <div class="pattern-item">🏃</div>
        <div class="pattern-item">🌟</div>
        <div class="pattern-item">💡</div>
    </div>

    <!-- Barra superior reorganizada -->
    @include('plantilla.header')

    <!-- Contenido principal -->
    <div class="main-content">
        <div class="welcome-section">
            <h1>¡Bienvenido a PEDKIDS!</h1>
            <p>Grado {{ $grado }} - Selecciona una asignatura para comenzar</p>
        </div>

        <!-- Tarjetas de asignaturas rediseñadas -->
        <div class="subjects-container">
            @php
                $colorClasses = ['math-card', 'language-card', 'science-card', 'social-card'];
                $badges = ['HOT SALE', 'LATEST DEALS', 'NEW', 'POPULAR'];
                $decorations = ['decorative-lines', 'decorative-circles'];
            @endphp
            @foreach ($asignaturas as $index => $asignatura)
            @php
                $colorClass = $colorClasses[$index % count($colorClasses)];
                $badge = $badges[$index % count($badges)];
                $decoration = $decorations[$index % count($decorations)];
            @endphp
            <div class="subject-card {{ $colorClass }}" data-subject="{{ $asignatura->id }}">
            <div class="subject-image">
                    <div class="image-container">
                        <img src="{{ session('url_ped') }}/app-assets/images/Img_Modulos/{{ $asignatura->url_img }}" alt="{{ $asignatura->nombre }}" class="subject-img">
                        <div class="{{ $decoration }}"></div>
                    </div>
                </div>    
            <div class="card-content">
                    <div class="subject-badge">{{ $asignatura->nombre_area }}</div>
                    <h2 class="subject-title">{{ $asignatura->nombre }}</h2>
                    <p class="subject-price">{{substr($asignatura->presentacion_modulo, 0, 100).'...'}}</p>
                    <button class="subject-btn">¡Aprender!</button>
                </div>
             
                </div>
            @endforeach
            
        </div>

    <!-- Menú lateral de módulos -->
    @include('partials.sidebar')

    <!-- Controles de audio en la parte inferior lateral -->
    <div class="audio-controls-bottom">
        <button class="control-btn" id="voiceBtn" title="Activar/Desactivar Voz">
            <i class="fas fa-volume-up"></i>
        </button>
        <button class="control-btn" id="musicBtn" title="Activar/Desactivar Música">
            <i class="fas fa-music"></i>
        </button>
    </div>

    <script>
        // Variables y funciones globales para que el sidebar pueda acceder
        let voiceEnabled = true;
        
        function playVoiceText(text) {
            if (!voiceEnabled) return;
            
            if ('speechSynthesis' in window) {
                const utterance = new SpeechSynthesisUtterance(text);
                utterance.lang = 'es-ES';
                utterance.rate = 0.8;
                utterance.pitch = 1.2;
                speechSynthesis.speak(utterance);
            }
        }
        
        class AsignaturasManager {
            constructor() {
                this.voiceEnabled = true;
                this.musicEnabled = true;
                this.setupEventListeners();
                this.setupVoiceHover();
            }

            setupEventListeners() {
                // Botones de audio
                const voiceBtn = document.getElementById('voiceBtn');
                const musicBtn = document.getElementById('musicBtn');

                if (voiceBtn) {
                    voiceBtn.addEventListener('click', () => {
                        this.voiceEnabled = !this.voiceEnabled;
                        voiceEnabled = this.voiceEnabled; // Sincronizar con variable global
                        this.playVoiceText('Voz ' + (this.voiceEnabled ? 'activa' : 'desactivada'));
                        voiceBtn.innerHTML = this.voiceEnabled ? '<i class="fas fa-volume-up"></i>' : '<i class="fas fa-volume-off"></i>';
                    });
                }

                if (musicBtn) {
                    musicBtn.addEventListener('click', () => {
                        this.musicEnabled = !this.musicEnabled;
                        this.playVoiceText('Música ' + (this.musicEnabled ? 'activa' : 'desactivada'));
                        musicBtn.innerHTML = this.musicEnabled ? '<i class="fas fa-music"></i>' : '<i class="fas fa-volume-off"></i>';
                    });
                }
            
                // Tarjetas de asignaturas
                document.querySelectorAll('.subject-card').forEach(card => {
                    card.addEventListener('click', () => {
                        const subject = card.dataset.subject;
                        this.selectSubject(subject);
                    });

                    // Efecto hover con voz
                    card.addEventListener('mouseenter', () => {
                        const title = card.querySelector('.subject-title').textContent;
                        if (this.voiceEnabled) {
                            this.playVoiceText(title);
                        }
                    });
                });
            }

            setupVoiceHover() {
                // Activar voz en hover para elementos de texto
                const textElements = document.querySelectorAll('h1, h2, p, .subject-title, .subject-price');
                textElements.forEach(element => {
                    element.addEventListener('mouseenter', () => {
                        if (this.voiceEnabled) {
                            this.playVoiceText(element.textContent);
                        }
                    });
                });

                // Voz especial para el nombre del usuario
                const userName = document.querySelector('.user-name');
                if (userName) {
                    userName.addEventListener('mouseenter', () => {
                        if (this.voiceEnabled) {
                            this.playVoiceText(`Hola ${userName.textContent.trim()}, bienvenido a PEDKIDS`);
                        }
                    });
                }
            }

            selectSubject(subject) {
                if (this.voiceEnabled) {
                    this.playVoiceText(`Entrando a ${subject}`);
                }
                
                // Animación de selección
                const card = document.querySelector(`[data-subject="${subject}"]`);
                card.style.transform = 'scale(0.95)';
                
                setTimeout(() => {
                    card.style.transform = 'scale(1)';
                    // Redirigir a la página de detalle de la asignatura
                    window.location.href = `/asignatura/${subject}`;
                }, 200);
            }

            playVoiceText(text) {
                if (this.voiceEnabled) {
                    playVoiceText(text); // Llamar a la función global
                }
            }
        }

        function logout() {
            if (confirm('¿Estás seguro de que quieres cerrar sesión?')) {
                window.location.href = '/logout';
            }
        }

        // Inicializar cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', () => {
            new AsignaturasManager();
        });
    </script>
</body>
</html>