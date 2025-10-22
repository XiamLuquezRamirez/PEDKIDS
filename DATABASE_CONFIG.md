# 🗄️ Configuración de Base de Datos para PEDKIDS

## ⚠️ Estado Actual
El sistema actualmente está usando **datos de fallback** porque no hay conexión a la base de datos.

## 📋 Pasos para Configurar la Base de Datos

### 1. Iniciar el Servidor MySQL
```bash
# En XAMPP Control Panel:
- Hacer clic en "Start" junto a MySQL
- O ejecutar: net start MySQL
```

### 2. Crear la Base de Datos
```sql
-- Abrir phpMyAdmin o MySQL Workbench y ejecutar:
CREATE DATABASE IF NOT EXISTS pedkids CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE pedkids;
```

### 3. Crear las Tablas

#### Tabla `users`
```sql
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `usuario` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `avatar_kid` varchar(10) DEFAULT NULL COMMENT 'Emoji del personaje',
  `pw_kid` json DEFAULT NULL COMMENT 'Array de emojis para password',
  `estado_usuario` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

#### Tabla `alumnos`
```sql
CREATE TABLE `alumnos` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `usuario_alumno` bigint(20) UNSIGNED NOT NULL,
  `nombre_alumno` varchar(255) NOT NULL,
  `apellido_alumno` varchar(255) NOT NULL,
  `grado_alumno` int(11) NOT NULL COMMENT '1 a 5',
  `grupo` varchar(10) NOT NULL COMMENT 'A, B, C, etc',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_alumno` (`usuario_alumno`),
  CONSTRAINT `alumnos_usuario_fk` FOREIGN KEY (`usuario_alumno`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### 4. Insertar Datos de Prueba

#### Para Grados 1-2 (con emojis)
```sql
-- Usuario 1: Ana García - Grado 1, Grupo A
INSERT INTO `users` (`usuario`, `avatar_kid`, `pw_kid`, `estado_usuario`) 
VALUES ('ana.garcia', '🐸', '["estrella", "corazon", "sol"]', 'ACTIVO');

INSERT INTO `alumnos` (`usuario_alumno`, `nombre_alumno`, `apellido_alumno`, `grado_alumno`, `grupo`) 
VALUES (LAST_INSERT_ID(), 'Ana', 'García', 1, 'A');

-- Usuario 2: Carlos López - Grado 1, Grupo A
INSERT INTO `users` (`usuario`, `avatar_kid`, `pw_kid`, `estado_usuario`) 
VALUES ('carlos.lopez', '🐱', '["luna", "arcoiris", "flor"]', 'ACTIVO');

INSERT INTO `alumnos` (`usuario_alumno`, `nombre_alumno`, `apellido_alumno`, `grado_alumno`, `grupo`) 
VALUES (LAST_INSERT_ID(), 'Carlos', 'López', 1, 'A');

-- Usuario 3: María Rodríguez - Grado 1, Grupo B
INSERT INTO `users` (`usuario`, `avatar_kid`, `pw_kid`, `estado_usuario`) 
VALUES ('maria.rodriguez', '🐰', '["estrella", "luna", "corazon"]', 'ACTIVO');

INSERT INTO `alumnos` (`usuario_alumno`, `nombre_alumno`, `apellido_alumno`, `grado_alumno`, `grupo`) 
VALUES (LAST_INSERT_ID(), 'María', 'Rodríguez', 1, 'B');

-- Usuario 4: Diego Martínez - Grado 2, Grupo A
INSERT INTO `users` (`usuario`, `avatar_kid`, `pw_kid`, `estado_usuario`) 
VALUES ('diego.martinez', '🐻', '["arcoiris", "sol", "flor"]', 'ACTIVO');

INSERT INTO `alumnos` (`usuario_alumno`, `nombre_alumno`, `apellido_alumno`, `grado_alumno`, `grupo`) 
VALUES (LAST_INSERT_ID(), 'Diego', 'Martínez', 2, 'A');
```

#### Para Grados 3-5 (login normal)
```sql
-- Usuario 5: Sofía Hernández - Grado 3, Grupo A
INSERT INTO `users` (`usuario`, `password`, `estado_usuario`) 
VALUES ('sofia.hernandez', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ACTIVO'); -- password: sofia123

INSERT INTO `alumnos` (`usuario_alumno`, `nombre_alumno`, `apellido_alumno`, `grado_alumno`, `grupo`) 
VALUES (LAST_INSERT_ID(), 'Sofía', 'Hernández', 3, 'A');
```

### 5. Verificar la Configuración

#### Archivo `.env`
Verificar que exista el archivo `.env` con:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pedkids
DB_USERNAME=root
DB_PASSWORD=
```

#### Probar la Conexión
```bash
php artisan tinker
>>> DB::connection()->getPdo();
>>> DB::table('users')->count();
```

## 🔄 Mapeo de Emojis

El campo `pw_kid` guarda un array JSON con los nombres de los emojis:

| Nombre | Emoji | Código |
|--------|-------|--------|
| estrella | ⭐ | `"estrella"` |
| corazon | ❤️ | `"corazon"` |
| sol | ☀️ | `"sol"` |
| luna | 🌙 | `"luna"` |
| arcoiris | 🌈 | `"arcoiris"` |
| flor | 🌸 | `"flor"` |

**Ejemplo:**
```json
["estrella", "corazon", "sol"]
```
Se mostrará como: ⭐ ❤️ ☀️

## 📊 Estructura de Datos Esperada por el Frontend

```json
{
  "grados": {
    "1": {
      "grupos": {
        "A": {
          "nombre": "Grupo A",
          "estudiantes": [
            {
              "id": 1,
              "nombre": "Ana",
              "apellido": "García",
              "personaje": "🐸",
              "password_emoji": ["estrella", "corazon", "sol"]
            }
          ]
        }
      }
    }
  }
}
```

## 🚀 Activar la Conexión a BD

Una vez configurada la base de datos:

1. Verifica que MySQL esté corriendo
2. Verifica que la BD `pedkids` exista
3. Verifica las credenciales en `.env`
4. Limpia la caché: `php artisan config:clear`
5. Recarga la página de inicio

El sistema automáticamente cambiará de datos de fallback a datos reales de la base de datos.

## ⚙️ Modo Fallback Actual

Mientras no esté configurada la BD, el sistema usa datos de prueba definidos en:
- `app/Http/Controllers/EstudiantesController.php` → método `getFallbackData()`

Estos datos incluyen:
- Grado 1: Grupo A (Ana, Carlos), Grupo B (María)
- Grado 2: Grupo A (Diego)
- Grado 3: Grupo A (Sofía)

