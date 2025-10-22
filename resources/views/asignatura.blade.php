<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PEDKIDS - {{ $asignatura['nombre'] }}</title>
    <link rel="stylesheet" href="{{ asset('css/asignaturas.css') }}">
    <link rel="stylesheet" href="{{ asset('css/asignatura-detalle.css') }}">
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

    <!-- Menú lateral de módulos -->
    @include('partials.sidebar')

    <!-- Barra superior reorganizada -->
    @include('plantilla.header')

    <!-- Contenido principal -->
    <div class="main-content-detail">
        <!-- Información de la asignatura -->
        <div class="subject-info">
            <div class="subject-description">
                <p>{{ $asignatura['descripcion'] }}</p>
            </div>
        </div>

        <!-- Vista principal: Períodos -->
        <div class="main-view" id="mainView">
            <div class="periods-navigation">
                <h2>Períodos Académicos</h2>
                <div class="periods-grid">
                    @foreach($asignatura['periodos'] as $periodoKey => $periodo)
                    <div class="period-card" data-period="{{ $periodoKey }}" onclick="selectPeriod('{{ $periodoKey }}')">
                        <div class="period-number">{{ $loop->iteration }}</div>
                        <div class="period-info">
                            <h3>{{ $periodo['nombre'] }}</h3>
                        </div>
                        <div class="period-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Vista de unidades (se muestra al seleccionar período) -->
        <div class="units-view" id="unitsView" style="display: none;">
            <div class="view-header">
                <button class="back-btn" onclick="goBackToPeriods()">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <h2 id="unitsViewTitle">Unidades del Período</h2>
            </div>
            <div class="units-grid" id="unitsGrid">
                <!-- Se llena dinámicamente -->
            </div>
        </div>

        <!-- Vista de temas (se muestra al seleccionar unidad) -->
        <div class="topics-view" id="topicsView" style="display: none;">
            <div class="view-header">
                <button class="back-btn" onclick="goBackToUnits()">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <h2 id="topicsViewTitle">Temas de la Unidad</h2>
            </div>
            <div class="topics-grid" id="topicsGrid">
                <!-- Se llena dinámicamente -->
            </div>
        </div>

        <!-- Vista de recursos (se muestra al seleccionar tema) -->
        <div class="resources-view" id="resourcesView" style="display: none;">
            <div class="view-header">
                <button class="back-btn" onclick="goBackToTopics()">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <h2 id="resourcesViewTitle">Recursos del Tema</h2>
            </div>

            <!-- Descripción del tema -->
            <div class="topic-description-container" id="topicDescriptionContainer">
                <div class="topic-description-card">
                    <div class="topic-description-header">
                        <div class="header-left-section">
                            <i class="fas fa-book-open"></i>
                            <h3>Descripción del Tema</h3>
                        </div>
                        <button class="read-text-btn" id="readDescriptionBtn" onclick="toggleReadDescription()" title="Leer descripción">
                            <i class="fas fa-volume-up"></i>
                            <span class="btn-text">Leer</span>
                        </button>
                    </div>
                    <div class="topic-description-content" id="topicDescriptionContent">
                        <!-- Se llena dinámicamente con HTML -->
                    </div>
                </div>
            </div>

            <!-- Mensaje para usar el panel de recursos -->
            <div class="resources-info-message">
                <div class="info-icon">
                    <i class="fas fa-info-circle"></i>
                </div>
                <p>Para acceder a los recursos de este tema, revisa el panel <strong>"Recursos Disponibles"</strong> en el lado derecho de la pantalla.</p>
                <div class="arrow-right-animated">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Barra lateral de recursos -->
    <div class="resources-sidebar" id="resourcesSidebar">
        <div class="sidebar-header">
            <h3>Recursos del Tema</h3>
            <button class="close-sidebar" onclick="closeSidebar()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="sidebar-content" id="sidebarContent">
            <!-- Contenido dinámico -->
        </div>
    </div>

    <!-- Modal de recurso -->
    <div class="resource-modal" id="resourceModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Título del Recurso</h3>
                <button class="close-modal" onclick="closeModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Contenido dinámico -->
            </div>
            <div id="video-container" style="display: none;">
                <video id="video-player" controls>
                    <source src="" type="video/mp4">
                    El navegador no soporta el video.
                </video>
            </div>
            <div class="modal-footer">
                <button class="modal-btn primary" style="display: none;" id="backButton" onclick="mostrarVideo()">
                    <li class="fas fa-arrow-left"></li>Atrás
                </button>
                <button class="modal-btn secondary" onclick="closeModal()">
                    <li class="fas fa-times"></li>Cerrar
                </button>
            </div>
        </div>
    </div>

    <!-- Controles de audio -->
    <div class="audio-controls-bottom">
        <button class="control-btn" id="voiceBtn" title="Activar/Desactivar Voz">
            <i class="fas fa-volume-up"></i>
        </button>
        <button class="control-btn" id="musicBtn" title="Activar/Desactivar Música">
            <i class="fas fa-music"></i>
        </button>
    </div>

    <!-- Panel lateral de recursos disponibles (aparece al seleccionar un tema) -->
    <div class="resources-panel" id="resourcesPanel">
        <div class="resources-panel-header">
            <h3><i class="fas fa-layer-group"></i> Recursos Disponibles</h3>
            <button class="close-panel" onclick="closeResourcesPanel()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="resources-panel-content" id="resourcesPanelContent">
            <!-- Se llena dinámicamente con los recursos del tema -->
        </div>
    </div>

    <!-- Botón flotante para abrir panel de recursos -->
    <div class="resources-float-btn" id="resourcesFloatBtn" style="display: none;">
        <button class="float-btn" onclick="openResourcesPanel()" title="Ver recursos disponibles">
            <i class="fas fa-layer-group"></i>
            <span class="float-btn-text">Recursos</span>
        </button>
    </div>

    <script>
        // Variables y funciones globales para que el sidebar pueda acceder
        let voiceEnabled = true;
        let urlPed = @json(session('url_ped'));
        let urlPedKids = @json(session('url_pedKids'));

    

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

        class AsignaturaManager {
            constructor() {
                this.voiceEnabled = true;
                this.musicEnabled = true;
                this.currentPeriod = null;
                this.currentUnit = null;
                this.currentTopic = null;
                this.asignaturaData = @json($asignatura);
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
            }

            setupVoiceHover() {
                const textElements = document.querySelectorAll('h1, h2, h3, h4, h5, p, .topic-title, .unit-info');
                textElements.forEach(element => {
                    element.addEventListener('mouseenter', () => {
                        if (this.voiceEnabled) {
                            this.playVoiceText(element.textContent);
                        }
                    });
                });
            }

            // Navegación jerárquica
            selectPeriod(periodKey) {
                this.currentPeriod = periodKey;
                const period = this.asignaturaData.periodos[periodKey];

                // Ocultar vista principal y mostrar vista de unidades
                document.getElementById('mainView').style.display = 'none';
                document.getElementById('unitsView').style.display = 'block';
                document.getElementById('unitsViewTitle').textContent = `Unidades - ${period.nombre}`;

                // Llenar grid de unidades
                this.populateUnitsGrid(period);

                if (this.voiceEnabled) {
                    this.playVoiceText(`Período: ${period.nombre}`);
                }
            }

            populateUnitsGrid(period) {
                const unitsGrid = document.getElementById('unitsGrid');
                unitsGrid.innerHTML = '';

                Object.entries(period.unidades).forEach(([unitKey, unit]) => {
                    const unitCard = document.createElement('div');
                    unitCard.className = 'unit-card';
                    unitCard.onclick = () => this.selectUnit(unitKey);

                    unitCard.innerHTML = `
                        <div class="unit-icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="unit-info">
                            <h3>${unit.nombre}</h3>
                            <p>${unit.descripcion}</p>
                        </div>
                        <div class="unit-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    `;

                    unitsGrid.appendChild(unitCard);
                });
            }

            selectUnit(unitKey) {
                this.currentUnit = unitKey;
                const period = this.asignaturaData.periodos[this.currentPeriod];
                const unit = period.unidades[unitKey];

                // Ocultar vista de unidades y mostrar vista de temas
                document.getElementById('unitsView').style.display = 'none';
                document.getElementById('topicsView').style.display = 'block';
                document.getElementById('topicsViewTitle').textContent = `Temas - ${unit.nombre}`;

                // Llenar grid de temas
                this.populateTopicsGrid(unit);

                if (this.voiceEnabled) {
                    this.playVoiceText(`Unidad: ${unit.nombre}`);
                }
            }

            populateTopicsGrid(unit) {
                const topicsGrid = document.getElementById('topicsGrid');
                topicsGrid.innerHTML = '';

                Object.entries(unit.temas).forEach(([topicKey, topic]) => {
                    const topicCard = document.createElement('div');
                    topicCard.className = 'topic-card';
                    topicCard.onclick = () => this.selectTopic(topicKey, topic);

                    // Contar recursos disponibles
                    const resourceCount = this.countTopicResources(topic);

                    topicCard.innerHTML = `
                        <div class="topic-icon">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <div class="topic-info">
                            <h3>${topic.nombre}</h3>
                            <p>${topic.descripcion}</p>
                            <div class="topic-resources-count">
                                ${resourceCount} recursos disponibles
                            </div>
                        </div>
                        <div class="topic-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    `;

                    topicsGrid.appendChild(topicCard);
                });
            }

            countTopicResources(topic) {
                let count = 0;
                if (topic.video) count++;
                if (topic.modelo_3d) count++;
                if (topic.evaluacion) count++;
                if (topic.evaluacion_inicio) count++;
                if (topic.produccion) count++;
                return count;
            }

            selectTopic(topicKey, topic) {
                this.currentTopic = topicKey;

                // Ocultar vista de temas y mostrar vista de recursos
                document.getElementById('topicsView').style.display = 'none';
                document.getElementById('resourcesView').style.display = 'block';
                document.getElementById('resourcesViewTitle').textContent = `${topic.nombre}`;

                // Mostrar descripción HTML del tema
                this.showTopicDescription(topic);

                // Mostrar panel de recursos disponibles
                this.showResourcesPanel(topic);

                if (this.voiceEnabled) {
                    this.playVoiceText(`Tema: ${topic.nombre}. Revisa el panel de recursos disponibles en el lado derecho.`);
                }
            }

            showTopicDescription(topic) {
                const descriptionContent = document.getElementById('topicDescriptionContent');

                if (topic.descripcion_html) {
                    // Usar descripción HTML si está disponible
                    descriptionContent.innerHTML = topic.descripcion_html.cont_documento;
                }
            }


            // Navegación hacia atrás
            goBackToPeriods() {
                document.getElementById('unitsView').style.display = 'none';
                document.getElementById('mainView').style.display = 'block';
                this.currentPeriod = null;
            }

            goBackToUnits() {
                document.getElementById('topicsView').style.display = 'none';
                document.getElementById('unitsView').style.display = 'block';
                this.currentUnit = null;
            }

            goBackToTopics() {
                document.getElementById('resourcesView').style.display = 'none';
                document.getElementById('topicsView').style.display = 'block';
                this.currentTopic = null;

                // Cerrar panel de recursos y ocultar botón flotante
                const panel = document.getElementById('resourcesPanel');
                const floatBtn = document.getElementById('resourcesFloatBtn');

                panel.classList.remove('show');
                floatBtn.classList.remove('show');
                floatBtn.style.display = 'none';
            }

            showResourcesPanel(topic) {
                const panel = document.getElementById('resourcesPanel');
                const panelContent = document.getElementById('resourcesPanelContent');

                panelContent.innerHTML = '';

                const resourcesData = [];

              

                // Agregar cada recurso disponible al array
                if (topic.video) {
                    resourcesData.push({
                        type: 'video',
                        icon: 'fas fa-play-circle',
                        title: 'Video',
                        description: topic.video.titulo || 'Ver video explicativo',
                        color: '#E74C3C',
                        data: topic.video,
                        tema: topic.nombre
                    });
                }

                if (topic.modelo_3d) {
                    resourcesData.push({
                        type: 'model3d',
                        icon: 'fas fa-cube',
                        title: 'Modelo 3D',
                        description:  'Explorar modelo 3D',
                        color: '#9B59B6',
                        data: topic.modelo_3d,
                        tema: topic.nombre
                    });
                }

                if (topic.evaluacion_inicio) {
                    resourcesData.push({
                        type: 'inicio',
                        icon: 'fas fa-clipboard-check',
                        title: 'Evaluación de inicio',
                        description: topic.evaluacion_inicio.titulo || 'Evaluación de inicio',
                        color: '#F39C12',
                        data: topic.evaluacion_inicio,
                        tema: topic.nombre
                    });
                }

                if (topic.evaluacion_produccion) {
                    resourcesData.push({
                        type: 'produccion',
                        icon: 'fas fa-clipboard-check',
                        title: topic.evaluacion_produccion.titulo || 'Evaluación de producción',
                        description: topic.evaluacion_produccion.titulo || 'Evaluación de producción',
                        color: '#E67E22',
                        data: topic.evaluacion_produccion,
                        tema: topic.nombre
                    });
                }

                // Crear elementos del panel
                resourcesData.forEach(resource => {
                    const item = document.createElement('div');
                    item.className = 'resource-panel-item';

                    item.onclick = () => {
                        this.showResourceModal(resource.type, typeof resource.data === 'string' ? resource.data : JSON.stringify(resource.data), resource.tema);
                    };

                    if (resource.type == 'video') {
                        item.innerHTML = `
                            <div class="resource-icon" style="background: ${resource.color};">
                                <i class="${resource.icon}"></i>
                            </div>
                            <div class="resource-info">
                                <h4>${resource.title}</h4>
                                <p>${resource.description}</p>
                            </div>
                        `;
                    } else if (resource.type == 'model3d') {
                        item.innerHTML = `
                            <div class="resource-icon" style="background: ${resource.color};">
                                <i class="${resource.icon}"></i>
                            </div>
                            <div class="resource-info">
                                <h4>${resource.title}</h4>
                                <p>${resource.description}</p>
                            </div>
                        `;
                    } else if (resource.type == 'inicio') {
                        item.innerHTML = `
                            <div class="resource-icon" style="background: ${resource.color};">
                                <i class="${resource.icon}"></i>
                            </div>
                            <div class="resource-info">
                                <h4>${resource.title}</h4>
                                <p>${resource.description}</p>
                            </div>
                        `;
                    } else if (resource.type == 'produccion') {
                        item.innerHTML = `
                            <div class="resource-icon" style="background: ${resource.color};">
                                <i class="${resource.icon}"></i>
                            </div>
                            <div class="resource-info">
                                <h4>${resource.title}</h4>
                                <p>${resource.description}</p>
                            </div>
                        `;
                    }


                    panelContent.appendChild(item);
                });

                // Si no hay recursos, mostrar mensaje
                if (resourcesData.length === 0) {
                    panelContent.innerHTML = '<div class="no-resources"><i class="fas fa-info-circle"></i><p>No hay recursos disponibles para este tema</p></div>';
                }

                // Mostrar panel con animación
                panel.classList.add('show');

                // Ocultar botón flotante
                const floatBtn = document.getElementById('resourcesFloatBtn');
                if (floatBtn) {
                    floatBtn.classList.remove('show');
                    floatBtn.style.display = 'none';
                }
            }

            showResourceModal(type, content, tema) {
                const modal = document.getElementById('resourceModal');
                const title = document.getElementById('modalTitle');
                const body = document.getElementById('modalBody');
                console.log(tema);
                if (type == 'model3d') {
                    let resourceData = content;
                } else {
                    let resourceData = JSON.parse(content);
                }

                switch (type) {
                    case 'video':
                        title.textContent = `Video del tema ${tema}`;
                        //recorrer el array de videos y mostrar el video que coincide con el tema
                        let videoHtml = '';
                        resourceData.forEach(video => {
                            videoHtml += `
                                <div class="video-item" onclick="verVideo('${video.cont_didactico}')">
                                    <li class="video-item-button-play">
                                        <i class="fas fa-play-circle"></i>
                                        <span>Ver Video</span>
                                    </li>
                                    <div class="resource-info">
                                        <p>${video.titulo.slice(0, -3)}</p>

                                    </div>
                                
                                </div>
                            `;
                        });


                        body.innerHTML = videoHtml;
                        break;

                    case 'model3d':
                        title.textContent = 'Modelo 3D';
                        body.innerHTML = `
                            <div class="model3d-preview">
                                <div class="model3d-info">
                                    <p>Explora el modelo 3D</p>
                                </div>
                                <div class="model3d-placeholder">
                                    <i class="fas fa-cube"></i>
                                    <p>Modelo 3D: ${tema}</p>
                                </div>
                            </div>
                        `;
                        break;

                    case 'evaluation':
                        title.textContent = resourceData.titulo;
                        body.innerHTML = `
                            <div class="evaluation-preview">
                                <div class="evaluation-info">
                                    <p>${resourceData.descripcion}</p>
                                </div>
                                <div class="evaluation-placeholder">
                                    <i class="fas fa-gamepad"></i>
                                    <p>Juego: ${resourceData.titulo}</p>
                                </div>
                            </div>
                        `;
                        actionBtn.innerHTML = '<i class="fas fa-gamepad"></i> Jugar';
                        actionBtn.onclick = () => this.openEvaluation(resourceData.url);
                        break;

                    case 'test':
                        title.textContent = 'Evaluación de Inicio';
                        body.innerHTML = `
                            <div class="test-preview">
                                <div class="test-info">
                                    <p>Demuestra lo que ya sabes antes de comenzar el tema</p>
                                </div>
                                <div class="test-placeholder">
                                    <i class="fas fa-clipboard-check"></i>
                                    <p>Evaluación de Conocimientos</p>
                                </div>
                            </div>
                        `;
                        actionBtn.innerHTML = '<i class="fas fa-clipboard-check"></i> Comenzar Test';
                        actionBtn.onclick = () => this.openTest();
                        break;

                    case 'production':
                        title.textContent = 'Actividad de Producción';
                        body.innerHTML = `
                            <div class="production-preview">
                                <div class="production-info">
                                    <p>Crea algo nuevo aplicando lo que has aprendido</p>
                                </div>
                                <div class="production-placeholder">
                                    <i class="fas fa-paint-brush"></i>
                                    <p>Actividad Creativa</p>
                                </div>
                            </div>
                        `;
                        actionBtn.innerHTML = '<i class="fas fa-paint-brush"></i> Crear';
                        actionBtn.onclick = () => this.openProduction();
                        break;
                }

                modal.classList.add('show');
                if (this.voiceEnabled) {
                    this.playVoiceText(`Abriendo ${title.textContent}`);
                }
            }

            openVideo(url) {
                document.getElementById('modalBody').style.display = 'none';
                document.getElementById('video-container').style.display = 'block';
                document.getElementById('video-player').src = url;
                document.getElementById('video-player').load();
                document.getElementById('video-player').play();
            }

            closeVideo() {
                document.getElementById('video-container').style.display = 'none';
                document.getElementById('modalBody').style.display = 'block';
                document.getElementById('video-player').src = '';
                document.getElementById('video-player').load();
                document.getElementById('video-player').pause();
            }

            openModel3D(url) {
                if (this.voiceEnabled) {
                    this.playVoiceText('Abriendo modelo en 3D');
                }
                // Aquí implementarías la lógica para abrir el modelo 3D
                console.log('Abriendo modelo 3D:', url);
            }

            openEvaluation(url) {
                if (this.voiceEnabled) {
                    this.playVoiceText('Iniciando juego de evaluación');
                }
                // Aquí implementarías la lógica para abrir la evaluación
                console.log('Abriendo evaluación:', url);
            }

            openTest() {
                if (this.voiceEnabled) {
                    this.playVoiceText('Iniciando evaluación de inicio');
                }
                // Aquí implementarías la lógica para el test
                console.log('Abriendo test');
            }

            openProduction() {
                if (this.voiceEnabled) {
                    this.playVoiceText('Iniciando actividad creativa');
                }
                // Aquí implementarías la lógica para la producción
                console.log('Abriendo producción');
            }

            playVoiceText(text) {
                if (this.voiceEnabled) {
                    playVoiceText(text); // Llamar a la función global
                }
            }
        }

        function closeResourcesPanel() {
            const panel = document.getElementById('resourcesPanel');
            const floatBtn = document.getElementById('resourcesFloatBtn');

            panel.classList.remove('show');

            // Mostrar botón flotante si hay contenido en el panel
            if (panel.querySelector('.resource-panel-item')) {
                floatBtn.style.display = 'block';
                setTimeout(() => floatBtn.classList.add('show'), 100);
            }
        }

        function openResourcesPanel() {
            const panel = document.getElementById('resourcesPanel');
            const floatBtn = document.getElementById('resourcesFloatBtn');

            panel.classList.add('show');
            floatBtn.classList.remove('show');
            setTimeout(() => floatBtn.style.display = 'none', 300);
        }

        let asignaturaManager;

        function goBack() {
            window.history.back();
        }

        function selectPeriod(periodKey) {
            asignaturaManager.selectPeriod(periodKey);
        }

        function goBackToPeriods() {
            asignaturaManager.goBackToPeriods();
        }

        function goBackToUnits() {
            asignaturaManager.goBackToUnits();
        }

        function goBackToTopics() {
            asignaturaManager.goBackToTopics();
        }

        function closeModal() {
            document.getElementById('resourceModal').classList.remove('show');
            //cerrar el video si esta abierto
            document.getElementById('video-container').style.display = 'none';
            document.getElementById('video-player').src = '';
            document.getElementById('video-player').load();
            document.getElementById('video-player').pause();
            document.getElementById('backButton').style.display = 'none';
        }

        function closeSidebar() {
            document.getElementById('resourcesSidebar').classList.remove('show');
        }

        function startTopic(topicKey, topicName) {
            if (confirm(`¿Estás listo para comenzar el tema: ${topicName}?`)) {
                // Aquí implementarías la lógica para comenzar el tema
               
            }
        }

        function logout() {
            if (confirm('¿Estás seguro de que quieres cerrar sesión?')) {
                window.location.href = '/logout';
            }
        }

        // Variables globales para controlar la lectura
        let isReading = false;
        let currentUtterance = null;

        function toggleReadDescription() {
            if (!voiceEnabled) {
                alert('Por favor, activa la voz desde los controles de audio en la parte inferior.');
                return;
            }

            const descriptionContent = document.getElementById('topicDescriptionContent');
            const readBtn = document.getElementById('readDescriptionBtn');

            if (!descriptionContent || !descriptionContent.textContent.trim()) {
                alert('No hay contenido para leer.');
                return;
            }

            if (isReading) {
                // Detener la lectura
                stopReading();
            } else {
                // Iniciar la lectura
                startReading(descriptionContent.textContent, readBtn);
            }
        }

        function startReading(text, button) {
            if ('speechSynthesis' in window) {
                // Cancelar cualquier lectura anterior
                window.speechSynthesis.cancel();

                // Crear nueva utterance
                currentUtterance = new SpeechSynthesisUtterance(text);
                currentUtterance.lang = 'es-ES';
                currentUtterance.rate = 0.85;
                currentUtterance.pitch = 1.1;

                // Evento cuando termina la lectura
                currentUtterance.onend = () => {
                    isReading = false;
                    button.classList.remove('reading');
                    button.innerHTML = '<i class="fas fa-volume-up"></i><span class="btn-text">Leer</span>';
                    button.title = 'Leer descripción';
                };

                // Evento si hay error
                currentUtterance.onerror = () => {
                    isReading = false;
                    button.classList.remove('reading');
                    button.innerHTML = '<i class="fas fa-volume-up"></i><span class="btn-text">Leer</span>';
                    button.title = 'Leer descripción';
                };

                // Iniciar lectura
                window.speechSynthesis.speak(currentUtterance);
                isReading = true;
                button.classList.add('reading');
                button.innerHTML = '<i class="fas fa-stop-circle"></i><span class="btn-text">Detener</span>';
                button.title = 'Detener lectura';
            } else {
                alert('Tu navegador no soporta la síntesis de voz.');
            }
        }

        function stopReading() {
            if ('speechSynthesis' in window) {
                window.speechSynthesis.cancel();
                isReading = false;

                const readBtn = document.getElementById('readDescriptionBtn');
                if (readBtn) {
                    readBtn.classList.remove('reading');
                    readBtn.innerHTML = '<i class="fas fa-volume-up"></i><span class="btn-text">Leer</span>';
                    readBtn.title = 'Leer descripción';
                }
            }
        }

        function verVideo(url) {
            document.getElementById('modalBody').style.display = 'none';
            document.getElementById('video-container').style.display = 'block';
            document.getElementById('video-player').src = urlPed + '/app-assets/Contenido_Didactico/' + url;
            document.getElementById('video-player').load();
            document.getElementById('video-player').play();
            document.getElementById('backButton').style.display = 'block';
        }

        // Inicializar cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', () => {
            asignaturaManager = new AsignaturaManager();
        });

        function mostrarVideo() {
            document.getElementById('video-container').style.display = 'none';
            document.getElementById('modalBody').style.display = 'block';
            document.getElementById('video-player').src = '';
            document.getElementById('video-player').load();
            document.getElementById('video-player').pause();
            document.getElementById('backButton').style.display = 'none';
        }
    </script>
</body>

</html>