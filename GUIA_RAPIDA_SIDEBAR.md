# 🚀 Guía Rápida: Cómo Agregar el Sidebar a Nuevas Vistas

## 📝 Pasos para Implementar el Sidebar

### 1. Incluir el Componente Parcial

En tu vista Blade (`.blade.php`), agrega esta línea **después del `<body>` pero antes del contenido principal**:

```blade
<!-- Menú lateral de módulos -->
@include('partials.sidebar')
```

### 2. Cargar el CSS

Asegúrate de tener esta línea en el `<head>` de tu vista:

```blade
<link rel="stylesheet" href="{{ asset('css/asignaturas.css') }}">
```

### 3. Agregar Función Global de Voz

En la sección `<script>` de tu vista, **antes** de cualquier otra clase o código JavaScript:

```javascript
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
    
    // Tu código JavaScript aquí...
</script>
```

### 4. Ajustar el Padding del Contenido

Tu contenedor principal debe tener padding izquierdo para no quedar oculto por el sidebar:

```css
.main-content {
    padding: 100px 20px 40px 100px; /* El 100px izquierdo es para el sidebar */
    transition: padding-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
```

### 5. Controles de Audio (Opcional)

Si quieres agregar controles de voz y música, incluye este HTML antes del cierre de `</body>`:

```blade
<!-- Controles de audio -->
<div class="audio-controls-bottom">
    <button class="control-btn" id="voiceBtn" title="Activar/Desactivar Voz">
        <i class="fas fa-volume-up"></i>
    </button>
    <button class="control-btn" id="musicBtn" title="Activar/Desactivar Música">
        <i class="fas fa-music"></i>
    </button>
</div>
```

Y el JavaScript para manejarlos:

```javascript
const voiceBtn = document.getElementById('voiceBtn');
const musicBtn = document.getElementById('musicBtn');

if (voiceBtn) {
    voiceBtn.addEventListener('click', () => {
        voiceEnabled = !voiceEnabled;
        playVoiceText('Voz ' + (voiceEnabled ? 'activa' : 'desactivada'));
        voiceBtn.innerHTML = voiceEnabled ? 
            '<i class="fas fa-volume-up"></i>' : 
            '<i class="fas fa-volume-off"></i>';
    });
}
```

---

## 📋 Ejemplo Completo de una Nueva Vista

```blade
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Nueva Vista - PEDKIDS</title>
    <link rel="stylesheet" href="{{ asset('css/asignaturas.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .main-content {
            padding: 100px 20px 40px 100px;
            max-width: 1400px;
            margin: 0 auto;
            transition: padding-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
</head>
<body>
    <!-- Menú lateral de módulos -->
    @include('partials.sidebar')

    <!-- Barra superior -->
    <div class="top-bar-new">
        <div class="header-left">
            <!-- Contenido izquierdo -->
        </div>
        
        <div class="header-center">
            <img src="{{ asset('images/logo.png') }}" alt="PEDKIDS" class="header-logo">
        </div>
        
        <div class="header-right">
            <div class="user-info">
                <div class="user-avatar">
                    <img src="{{ asset('images/avatars/default.png') }}" alt="Avatar" class="avatar-img">
                </div>
                <div class="user-name">{{ $user['nombre'] ?? 'Estudiante' }}</div>
            </div>
            <button class="logout-btn" onclick="logout()" title="Cerrar sesión">
                <i class="fas fa-sign-out-alt"></i>
            </button>
        </div>
    </div>

    <!-- Contenido principal -->
    <div class="main-content">
        <h1>Mi Contenido</h1>
        <p>Aquí va el contenido de tu vista...</p>
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

    <script>
        // Variables y funciones globales
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
        
        // Manejo de controles de audio
        const voiceBtn = document.getElementById('voiceBtn');
        const musicBtn = document.getElementById('musicBtn');

        if (voiceBtn) {
            voiceBtn.addEventListener('click', () => {
                voiceEnabled = !voiceEnabled;
                playVoiceText('Voz ' + (voiceEnabled ? 'activa' : 'desactivada'));
                voiceBtn.innerHTML = voiceEnabled ? 
                    '<i class="fas fa-volume-up"></i>' : 
                    '<i class="fas fa-volume-off"></i>';
            });
        }

        if (musicBtn) {
            musicBtn.addEventListener('click', () => {
                playVoiceText('Música alternada');
                // Aquí puedes agregar lógica de música
            });
        }

        function logout() {
            if (confirm('¿Estás seguro de que quieres cerrar sesión?')) {
                window.location.href = '/logout';
            }
        }
    </script>
</body>
</html>
```

---

## ✅ Checklist de Implementación

- [ ] Incluir `@include('partials.sidebar')`
- [ ] Cargar `css/asignaturas.css`
- [ ] Definir función global `playVoiceText()`
- [ ] Ajustar padding izquierdo del contenido (100px)
- [ ] (Opcional) Agregar controles de audio
- [ ] Probar en diferentes dispositivos
- [ ] Verificar que la voz funciona
- [ ] Comprobar navegación del sidebar

---

## 🎨 Personalización por Vista

Si necesitas estilos específicos para tu vista, puedes agregar:

```css
/* Sobrescribir padding si es necesario */
@media (max-width: 768px) {
    .main-content {
        padding: 90px 20px 40px 80px;
    }
}

@media (max-width: 480px) {
    .main-content {
        padding: 85px 10px 20px 60px;
    }
}
```

---

## 🐛 Problemas Comunes

### El sidebar no aparece
**Solución**: Verifica que el archivo `resources/views/partials/sidebar.blade.php` existe.

### El contenido queda oculto por el sidebar
**Solución**: Agrega `padding-left: 100px` a tu contenedor principal.

### La voz no funciona
**Solución**: Asegúrate de definir la función `playVoiceText()` **ANTES** del sidebar.

### El sidebar no se expande
**Solución**: Verifica que `asignaturas.css` esté cargado correctamente.

---

## 📚 Recursos Adicionales

- `partials/sidebar.blade.php` - Componente del sidebar
- `css/asignaturas.css` - Estilos del sidebar
- `README_MENU_LATERAL.md` - Documentación completa
- `README_ACTUALIZACION_MENU.md` - Detalles de la actualización

---

## 💡 Consejos

1. **Orden de carga**: Siempre incluye el sidebar después de `<body>` pero antes del contenido
2. **Función global**: Define `playVoiceText()` antes de cualquier clase JavaScript
3. **Responsive**: El sidebar se adapta automáticamente a móviles
4. **Z-index**: El sidebar tiene z-index 999, asegúrate de que tu contenido no lo supere
5. **Testing**: Prueba en Chrome, Firefox y Safari para asegurar compatibilidad

---

## 🎯 Siguiente Paso

¡Crea tu nueva vista y simplemente copia el código de ejemplo! El sidebar funcionará automáticamente.

**¿Necesitas ayuda?** Revisa las vistas existentes:
- `resources/views/asignaturas.blade.php`
- `resources/views/asignatura.blade.php`
- `resources/views/inicio.blade.php`

