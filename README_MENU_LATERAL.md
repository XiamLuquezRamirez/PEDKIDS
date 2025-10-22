# 📱 Menú Lateral de Módulos - PEDKIDS

## ✨ Características Implementadas

### 🎯 Nuevo Diseño Lateral

Se ha implementado un **menú lateral fijo** en el lado izquierdo de la pantalla con los siguientes módulos principales:

#### 🎨 Módulos Disponibles

1. **Free Zone** 🌤️
   - Icono: Nube con sol (cloud-sun)
   - Color: Amarillo/Naranja
   - Zona libre para explorar

2. **Juegos** 🎮
   - Icono: Gamepad
   - Color: Púrpura
   - Acceso a todos los juegos educativos

3. **Laboratorio** 🔬
   - Icono: Flask (matraz de laboratorio)
   - Color: Verde
   - Experimentos y prácticas

4. **ICFES** 🎓
   - Icono: Gorro de graduación
   - Color: Rojo
   - Preparación para pruebas

5. **Calificaciones** ⭐
   - Icono: Estrella
   - Color: Dorado
   - Ver notas y progreso

---

## 🎨 Características Visuales

### Diseño Responsivo
- **Desktop**: Sidebar de 80px cerrado, 250px abierto
- **Tablet**: Sidebar de 60px cerrado, 200px abierto
- **Móvil**: Sidebar de 50px cerrado, 180px abierto

### Efectos Interactivos
- ✅ **Hover con animaciones**: Los iconos se agrandan y rotan al pasar el mouse
- ✅ **Efecto pulse**: Animación de latido en los iconos
- ✅ **Tooltips**: Cuando el menú está cerrado, al pasar el mouse sobre un icono aparece el nombre del módulo
- ✅ **Barra lateral de color**: Aparece al hacer hover sobre cada módulo
- ✅ **Transiciones suaves**: Todo el menú se expande/colapsa con animaciones fluidas

### Colores por Módulo
Cada módulo tiene su propio esquema de colores para facilitar la identificación visual:
- **Free Zone**: Amarillo (#FDCB6E) - Naranja (#F39C12)
- **Juegos**: Púrpura (#A29BFE) - Morado (#6C5CE7)
- **Laboratorio**: Verde claro (#00B894) - Verde (#00A085)
- **ICFES**: Rojo (#E74C3C) - Rojo oscuro (#C0392B)
- **Calificaciones**: Amarillo dorado (#FDCB6E) - Dorado (#F1C40F)

---

## 🎤 Integración con Sistema de Voz

El menú lateral está **completamente integrado** con el sistema de lectura por voz:
- Al pasar el mouse sobre cada módulo, se lee su nombre
- Al abrir/cerrar el sidebar, se anuncia la acción
- Al hacer clic en un módulo, se anuncia que se está abriendo

---

## 🔧 Funcionalidad

### Toggle del Menú
- Click en el **botón superior** (icono de barras) para expandir/colapsar
- El icono rota 90° cuando el menú está abierto
- Click fuera del menú lo cierra automáticamente

### Navegación
Cada módulo redirige a su respectiva ruta:
```
/modulo/freezone
/modulo/games
/modulo/lab
/modulo/icfes
/modulo/grades
```

### Adaptación del Contenido
- El contenido principal se ajusta automáticamente cuando el sidebar se expande
- Padding dinámico para evitar que el contenido quede oculto
- Transiciones suaves en todos los cambios

---

## 📱 Compatibilidad

- ✅ Desktop (1920px+)
- ✅ Laptop (1366px - 1920px)
- ✅ Tablet (768px - 1365px)
- ✅ Mobile (320px - 767px)

---

## 🎯 Ventajas del Nuevo Diseño

1. **Acceso Rápido**: Los módulos principales están siempre visibles
2. **Intuitivo**: Iconos claros y colores diferenciados
3. **Ahorro de Espacio**: El menú se colapsa para no ocupar espacio
4. **Accesibilidad**: Compatible con lectores de pantalla y sistema de voz
5. **Diseño Infantil**: Colores vibrantes y animaciones divertidas
6. **Fácil Navegación**: Un solo click para acceder a cualquier módulo

---

## 🔄 Cambios Respecto al Diseño Anterior

### Antes:
- Menú de juegos en la parte inferior
- Ocupaba espacio horizontal completo
- Solo mostraba juegos individuales

### Ahora:
- Menú lateral con 5 módulos principales
- Ocupa espacio vertical del lado izquierdo
- Colapsa para ahorrar espacio
- Incluye Free Zone, Juegos, Laboratorio, ICFES y Calificaciones
- Más organizado y accesible

---

## 📝 Notas Técnicas

### Archivos Modificados:
1. `resources/views/asignaturas.blade.php`
   - HTML del nuevo sidebar
   - JavaScript para interactividad

2. `public/css/asignaturas.css`
   - Estilos del sidebar
   - Animaciones y efectos
   - Responsive design

### Tecnologías Utilizadas:
- HTML5
- CSS3 (Flexbox, Grid, Transitions, Animations)
- JavaScript (Vanilla JS)
- Font Awesome 6.0 (iconos)
- Speech Synthesis API (voz)

---

## 🎨 Personalización

Si deseas cambiar los colores de algún módulo, edita las siguientes clases en `asignaturas.css`:

```css
.freezone-module .module-icon { background: linear-gradient(...); }
.games-module .module-icon { background: linear-gradient(...); }
.lab-module .module-icon { background: linear-gradient(...); }
.icfes-module .module-icon { background: linear-gradient(...); }
.grades-module .module-icon { background: linear-gradient(...); }
```

---

## 🚀 Próximos Pasos

Para completar la funcionalidad, necesitarás crear las rutas y vistas para cada módulo:
- `/modulo/freezone`
- `/modulo/games`
- `/modulo/lab`
- `/modulo/icfes`
- `/modulo/grades`

---

**Fecha de Implementación**: 15 de Octubre, 2025  
**Versión**: 1.0  
**Proyecto**: PEDKIDS Educational Platform

