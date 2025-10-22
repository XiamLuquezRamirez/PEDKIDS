<!DOCTYPE html>
<html lang="es">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PEDIGITAL KIDS - Selecciona tu Grado</title>
    <link rel="stylesheet" href="{{ asset('css/inicio.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </head>
    <body>
    <!-- Controles de audio -->
    <div class="audio-controls">
        <button class="control-btn" id="musicBtn" title="Música de fondo">
            <i class="fa fa-music"></i>
        </button>
        <button class="control-btn" id="voiceBtn" title="Ayuda de voz">
            <i class="fa fa-volume-up"></i>
        </button>
    </div>

    <!-- Burbujas de fondo -->
    <div class="bubbles">
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
    </div>

    <div class="container">
        <div class="header">
            <img src="{{ asset('images/logo.png') }}" alt="PEDKIDS" class="logo">
            <p>¡Selecciona tu grado y comienza a aprender!</p>
        </div>

        <div class="grades-container">
            <div class="grade-card" data-grade="1" data-voice="Primer grado - Para niños de 6 a 7 años">
                <div class="grade-icon">📚</div>
                <div class="grade-number">1°</div>
                <div class="grade-title">Primer Grado</div>
                <div class="grade-description">
                    Aprende las bases de lectura, escritura y números. ¡El inicio de tu aventura educativa!
                </div>
            </div>

            <div class="grade-card" data-grade="2" data-voice="Segundo grado - Para niños de 7 a 8 años">
                <div class="grade-icon">✏️</div>
                <div class="grade-number">2°</div>
                <div class="grade-title">Segundo Grado</div>
                <div class="grade-description">
                    Fortalece tus habilidades básicas y descubre nuevas materias emocionantes.
                </div>
            </div>

            <div class="grade-card" data-grade="3" data-voice="Tercer grado - Para niños de 8 a 9 años">
                <div class="grade-icon">🧮</div>
                <div class="grade-number">3°</div>
                <div class="grade-title">Tercer Grado</div>
                <div class="grade-description">
                    Explora conceptos más avanzados en matemáticas, ciencias y literatura.
                </div>
            </div>

            <div class="grade-card" data-grade="4" data-voice="Cuarto grado - Para niños de 9 a 10 años">
                <div class="grade-icon">🔬</div>
                <div class="grade-number">4°</div>
                <div class="grade-title">Cuarto Grado</div>
                <div class="grade-description">
                    Sumérgete en experimentos científicos y desarrolla tu pensamiento crítico.
                </div>
            </div>

            <div class="grade-card" data-grade="5" data-voice="Quinto grado - Para niños de 10 a 11 años">
                <div class="grade-icon">🌍</div>
                <div class="grade-number">5°</div>
                <div class="grade-title">Quinto Grado</div>
                <div class="grade-description">
                    Conoce el mundo que te rodea y prepárate para nuevos desafíos académicos.
                </div>
            </div>
        
        </div>
    </div>

    <!-- Modal para selección de grupos -->
    <div id="groupModal" class="modal">
        <div class="modal-content">
            <span class="close">
                <i class="fa fa-times"></i>
            </span>
            <h2>🏫 Selecciona tu grupo</h2>
            <p id="groupInstruction">Elige tu grupo para continuar</p>
            
            <!-- Contenedor de selección de grupos -->
            <div id="groupSelection" class="groups-container">
                <!-- Los grupos se cargarán dinámicamente -->
            </div>
        </div>
    </div>

    <!-- Modal para selección de personajes (Grados 1-2) -->
    <div id="characterModal" class="modal">
        <div class="modal-content">
            <span class="close">
                <i class="fa fa-times"></i>
            </span>
            <h2 id="characterModalTitle">🎭 ¡Selecciona tu personaje!</h2>
            <p id="characterModalDesc">Elige el personaje con el que quieres aprender</p>
            
            <!-- Contenedor de selección de personajes -->
            <div id="characterSelection" class="characters-container">
                <div class="character-card" data-character="rana">
                    <div class="character-icon">🐸</div>
                    <div class="character-name">Rana</div>
                </div>
                <div class="character-card" data-character="gato">
                    <div class="character-icon">🐱</div>
                    <div class="character-name">Gato</div>
                </div>
                <div class="character-card" data-character="conejo">
                    <div class="character-icon">🐰</div>
                    <div class="character-name">Conejo</div>
                </div>
                <div class="character-card" data-character="oso">
                    <div class="character-icon">🐻</div>
                    <div class="character-name">Oso</div>
                </div>
                <div class="character-card" data-character="pez">
                    <div class="character-icon">🐠</div>
                    <div class="character-name">Pez</div>
                </div>
                <div class="character-card" data-character="pajaro">
                    <div class="character-icon">🐦</div>
                    <div class="character-name">Pájaro</div>
                </div>
            </div>

            <!-- Display del personaje seleccionado -->
            <div id="selectedCharacterDisplay" class="selected-character-display" style="display: none;">
                <div class="character-icon" id="selectedCharacterIcon"></div>
                <div class="character-name" id="selectedCharacterName"></div>
                <div class="character-welcome" id="selectedCharacterWelcome"></div>
            </div>

            <!-- Sección de contraseña -->
            <div class="password-section" id="passwordSection" style="display: none;">
                <div class="password-instruction">🔐 Ahora selecciona tu código de seguridad</div>
                <div class="password-instruction"><p>Toca las 3 figuras de tu contraseña</p></div>
                
                <div class="figures-container">
                    <div class="figure-card" data-figure="estrella">
                        <div class="figure-icon">⭐</div>
                    </div>
                    <div class="figure-card" data-figure="corazon">
                        <div class="figure-icon">❤️</div>
                    </div>
                    <div class="figure-card" data-figure="sol">
                        <div class="figure-icon">☀️</div>
                    </div>
                    <div class="figure-card" data-figure="luna">
                        <div class="figure-icon">🌙</div>
                    </div>
                    <div class="figure-card" data-figure="arcoiris">
                        <div class="figure-icon">🌈</div>
                    </div>
                    <div class="figure-card" data-figure="flor">
                        <div class="figure-icon">🌸</div>
                    </div>
                </div>
                
                <div id="passwordDisplay" class="password-display">
                    <div class="password-text"></div>
                    <div class="password-text"></div>
                    <div class="password-text"></div>
                </div>
                <button class="login-btn" id="enterBtn" disabled>🚀 ¡Entrar a PEDKIDS!</button>
            </div>
        </div>
    </div>

    <!-- Modal para login normal (Grados 3-5) -->
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close">
                <i class="fa fa-times"></i>
            </span>
            <h2 id="loginModalTitle">👤 ¡Bienvenido a PEDKIDS!</h2>
            <p id="loginModalDesc">Ingresa tus datos para continuar</p>
            
            <!-- Contenedor de selección de grupos para login -->
            <div id="loginGroupSelection" class="groups-container" style="display: none;">
                <!-- Los grupos se cargarán dinámicamente -->
            </div>
            
            <div class="login-form">
                <div class="form-group">
                    <label for="username">Nombre de usuario</label>
                    <input type="text" id="username" class="form-control" placeholder="Ingresa tu nombre de usuario">
                </div>
                
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" class="form-control" placeholder="Ingresa tu contraseña">
                </div>
                
                <button class="login-btn" id="normalLoginBtn">🚀 Ingresar</button>
            </div>
            
            <p style="margin-top: 20px; color: #7F8C8D;">
                <a href="#" style="color: #3498DB; text-decoration: none;">¿Olvidaste tu contraseña?</a>
            </p>
        </div>
    </div>

    <script src="{{ asset('js/pedkids-login.js') }}"></script>
   
    </body>
</html>
