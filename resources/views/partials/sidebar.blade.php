<!-- Menú lateral de módulos -->
<div class="sidebar-modules">
    <div class="sidebar-toggle" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </div>
    
    <div class="sidebar-content" id="sidebarContent">
        <div class="module-item freezone-module" data-module="freezone" data-tooltip="Free Zone">
            <div class="module-icon">
                <i class="fas fa-cloud-sun"></i>
            </div>
            <span class="module-label">Free Zone</span>
        </div>

        <div class="module-item games-module" data-module="games" data-tooltip="Juegos">
            <div class="module-icon">
                <i class="fas fa-gamepad"></i>
            </div>
            <span class="module-label">Juegos</span>
        </div>

        <div class="module-item lab-module" data-module="lab" data-tooltip="Laboratorio">
            <div class="module-icon">
                <i class="fas fa-flask"></i>
            </div>
            <span class="module-label">Laboratorio</span>
        </div>

        <div class="module-item icfes-module" data-module="icfes" data-tooltip="ICFES">
            <div class="module-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <span class="module-label">ICFES</span>
        </div>

        <div class="module-item grades-module" data-module="grades" data-tooltip="Calificaciones">
            <div class="module-icon">
                <i class="fas fa-star"></i>
            </div>
            <span class="module-label">Calificaciones</span>
        </div>
    </div>
</div>

<!-- Script para el sidebar (solo funcionalidad básica) -->
<script>
    (function() {
        let sidebarOpen = false;
        let voiceEnabled = true;

        function toggleSidebar() {
            sidebarOpen = !sidebarOpen;
            const sidebar = document.querySelector('.sidebar-modules');
            
            if (sidebarOpen) {
                sidebar.classList.add('open');
                if (voiceEnabled && typeof playVoiceText === 'function') {
                    playVoiceText('Menú de módulos abierto');
                }
            } else {
                closeSidebar();
            }
        }

        function closeSidebar() {
            sidebarOpen = false;
            const sidebar = document.querySelector('.sidebar-modules');
            sidebar.classList.remove('open');
        }

        function selectModule(moduleType) {
            const moduleNames = {
                'freezone': 'Free Zone',
                'games': 'Juegos',
                'lab': 'Laboratorio',
                'icfes': 'ICFES',
                'grades': 'Calificaciones'
            };
            
            if (voiceEnabled && typeof playVoiceText === 'function') {
                playVoiceText(`Abriendo ${moduleNames[moduleType]}`);
            }
            
            // Cerrar sidebar
            closeSidebar();
            
            // Redirigir al módulo específico
            window.location.href = `/modulo/${moduleType}`;
        }

        // Setup cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', toggleSidebar);

                // Cerrar sidebar al hacer clic fuera
                document.addEventListener('click', function(e) {
                    const sidebar = document.querySelector('.sidebar-modules');
                    if (sidebar && !sidebar.contains(e.target) && sidebarOpen) {
                        closeSidebar();
                    }
                });
            }

            // Módulos individuales
            document.querySelectorAll('.module-item').forEach(module => {
                module.addEventListener('click', function() {
                    const moduleType = this.dataset.module;
                    selectModule(moduleType);
                });

                // Efecto hover con voz
                module.addEventListener('mouseenter', function() {
                    const label = this.querySelector('.module-label').textContent;
                    if (voiceEnabled && typeof playVoiceText === 'function') {
                        playVoiceText(label);
                    }
                });
            });
        });
    })();
</script>

