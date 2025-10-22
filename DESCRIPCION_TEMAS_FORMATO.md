# Formato para Descripciones HTML de Temas

Este documento describe cómo estructurar las descripciones HTML de los temas en el archivo `asignaturas.json`.

## Estructura Básica

```html
<div class='tema-descripcion'>
    <h4>¿Qué aprenderás?</h4>
    <ul>
        <li>Objetivo 1</li>
        <li>Objetivo 2</li>
        <li>Objetivo 3</li>
        <li>Objetivo 4</li>
    </ul>
    
    <h4>Objetivos</h4>
    <p>Descripción detallada de los objetivos generales del tema.</p>
    
    <h4>Actividades</h4>
    <p>Descripción de las actividades que realizará el estudiante.</p>
    
    <h4>Importante</h4>
    <p>Notas importantes o consejos para el estudiante.</p>
</div>
```

## Secciones Disponibles

### 1. ¿Qué aprenderás?
Lista de puntos específicos que el estudiante dominará al finalizar el tema.

```html
<h4>¿Qué aprenderás?</h4>
<ul>
    <li>Punto específico 1</li>
    <li>Punto específico 2</li>
    <li>Punto específico 3</li>
</ul>
```

### 2. Objetivos
Descripción general de los objetivos del tema, más amplia y detallada.

```html
<h4>Objetivos</h4>
<p>Texto descriptivo explicando los objetivos generales del tema y su importancia.</p>
```

### 3. Actividades
Descripción de las actividades prácticas que realizará el estudiante.

```html
<h4>Actividades</h4>
<p>Descripción de juegos, ejercicios y prácticas que se realizarán.</p>
```

### 4. Importante (Opcional)
Notas importantes, consejos o advertencias para el estudiante.

```html
<h4>Importante</h4>
<p>Consejos, tips o información relevante para el estudiante.</p>
```

### 5. Prerequisitos (Opcional)
Conocimientos previos necesarios para abordar el tema.

```html
<h4>Prerequisitos</h4>
<p>Conocimientos que el estudiante debe tener antes de iniciar este tema.</p>
```

### 6. Duración Estimada (Opcional)
Tiempo aproximado para completar el tema.

```html
<h4>Duración Estimada</h4>
<p>Aproximadamente X horas de estudio y práctica.</p>
```

## Ejemplo Completo

```json
{
  "tema1": {
    "nombre": "Números del 1 al 20",
    "descripcion": "Aprende a contar y reconocer los primeros números",
    "descripcion_html": "<div class='tema-descripcion'><h4>¿Qué aprenderás?</h4><ul><li>Reconocer los números del 1 al 20</li><li>Contar objetos hasta 20</li><li>Escribir los números correctamente</li><li>Comparar cantidades pequeñas</li></ul><h4>Objetivos</h4><p>Al finalizar este tema, podrás identificar, leer y escribir los números del 1 al 20 de forma correcta. Aprenderás a contar objetos de tu entorno y a comparar cantidades.</p><h4>Actividades</h4><p>Realizarás juegos interactivos, verás videos animados y practicarás con ejercicios divertidos que te ayudarán a dominar estos números.</p><h4>Importante</h4><p>Practica todos los días contando objetos que encuentres en tu casa. Puedes contar tus juguetes, lápices, o cualquier cosa que te guste.</p><h4>Duración Estimada</h4><p>Aproximadamente 3-4 horas de estudio distribuidas en varios días.</p></div>",
    "evaluacion_inicio": true,
    "produccion": true,
    "video": { ... },
    "modelo_3d": { ... },
    "evaluacion": { ... }
  }
}
```

## Notas Importantes

1. **Todo el HTML debe estar en una sola línea** en el JSON para evitar problemas de formato.

2. **Usar comillas simples** (`'`) dentro del HTML para evitar conflictos con las comillas dobles del JSON.

3. **La clase `tema-descripcion`** es obligatoria en el div contenedor para aplicar los estilos correctamente.

4. **Los elementos `<h4>`** tienen estilos específicos con iconos y colores.

5. **Las listas `<ul>`** tienen checkmarks verdes automáticamente.

6. **Los párrafos `<p>`** están justificados y con espaciado adecuado.

## Estilos Aplicados Automáticamente

- ✓ Checkmarks verdes en listas
- Títulos azules con la fuente Fredoka One
- Párrafos justificados y legibles
- Espaciado optimizado para lectura
- Responsive design para móviles

## Herramienta para Convertir HTML

Para convertir HTML con saltos de línea a una sola línea:

```javascript
const html = `
<div class='tema-descripcion'>
    <h4>¿Qué aprenderás?</h4>
    <ul>
        <li>Item 1</li>
    </ul>
</div>
`;

const oneLine = html.replace(/\n\s*/g, '');
console.log(oneLine);
```

## Validación

Antes de agregar la descripción HTML al JSON, verifica:

1. ✓ Todas las etiquetas están correctamente cerradas
2. ✓ Se usan comillas simples dentro del HTML
3. ✓ El div principal tiene la clase `tema-descripcion`
4. ✓ El HTML está en una sola línea
5. ✓ No hay caracteres especiales sin escapar

