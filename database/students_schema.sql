-- Estructura de Base de Datos para PEDKIDS
-- Sistema de gestión de estudiantes con autenticación diferenciada

-- Tabla de grados
CREATE TABLE grados (
    id INT PRIMARY KEY AUTO_INCREMENT,
    numero INT NOT NULL UNIQUE,
    nombre VARCHAR(50) NOT NULL,
    tipo_autenticacion ENUM('emoji', 'normal') NOT NULL,
    activo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla de grupos
CREATE TABLE grupos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    grado_id INT NOT NULL,
    nombre VARCHAR(10) NOT NULL, -- A, B, C, etc.
    descripcion VARCHAR(100),
    activo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (grado_id) REFERENCES grados(id),
    UNIQUE KEY unique_grupo_grado (grado_id, nombre)
);

-- Tabla de estudiantes
CREATE TABLE estudiantes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    grupo_id INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    usuario VARCHAR(100) UNIQUE, -- Para grados 3-5
    password VARCHAR(255), -- Para grados 3-5 (hash)
    personaje VARCHAR(20), -- Para grados 1-2 (emoji)
    personaje_nombre VARCHAR(50), -- Para grados 1-2 (nombre del personaje)
    password_emoji JSON, -- Para grados 1-2 (array de emojis)
    activo BOOLEAN DEFAULT TRUE,
    ultimo_acceso TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (grupo_id) REFERENCES grupos(id)
);

-- Tabla de sesiones (para tracking de acceso)
CREATE TABLE sesiones_estudiantes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    estudiante_id INT NOT NULL,
    token VARCHAR(255) UNIQUE,
    tipo_login ENUM('emoji', 'normal') NOT NULL,
    datos_login JSON, -- Para almacenar datos específicos del login
    ip_address VARCHAR(45),
    user_agent TEXT,
    activa BOOLEAN DEFAULT TRUE,
    fecha_inicio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_fin TIMESTAMP NULL,
    FOREIGN KEY (estudiante_id) REFERENCES estudiantes(id)
);

-- Tabla de configuración de emojis disponibles
CREATE TABLE emojis_disponibles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    emoji VARCHAR(10) NOT NULL UNIQUE,
    nombre VARCHAR(50) NOT NULL,
    activo BOOLEAN DEFAULT TRUE
);

-- Insertar datos iniciales
INSERT INTO grados (numero, nombre, tipo_autenticacion) VALUES
(1, 'Primer Grado', 'emoji'),
(2, 'Segundo Grado', 'emoji'),
(3, 'Tercer Grado', 'normal'),
(4, 'Cuarto Grado', 'normal'),
(5, 'Quinto Grado', 'normal');

-- Insertar emojis disponibles
INSERT INTO emojis_disponibles (emoji, nombre) VALUES
('⭐', 'Estrella'),
('❤️', 'Corazón'),
('☀️', 'Sol'),
('🌙', 'Luna'),
('🌈', 'Arcoíris'),
('🌸', 'Flor');

-- Ejemplo de inserción de grupos
INSERT INTO grupos (grado_id, nombre, descripcion) VALUES
(1, 'A', 'Grupo A - Primer Grado'),
(1, 'B', 'Grupo B - Primer Grado'),
(2, 'A', 'Grupo A - Segundo Grado'),
(2, 'B', 'Grupo B - Segundo Grado'),
(3, 'A', 'Grupo A - Tercer Grado'),
(3, 'B', 'Grupo B - Tercer Grado'),
(4, 'A', 'Grupo A - Cuarto Grado'),
(4, 'B', 'Grupo B - Cuarto Grado'),
(5, 'A', 'Grupo A - Quinto Grado'),
(5, 'B', 'Grupo B - Quinto Grado');

-- Ejemplo de inserción de estudiantes (Grados 1-2 con emojis)
INSERT INTO estudiantes (grupo_id, nombre, apellido, personaje, personaje_nombre, password_emoji) VALUES
-- Grado 1 Grupo A
(1, 'Ana', 'García', '🐸', 'rana', '["⭐", "❤️", "☀️"]'),
(1, 'Carlos', 'López', '🐱', 'gato', '["🌙", "🌈", "🌸"]'),
(1, 'María', 'Rodríguez', '🐰', 'conejo', '["⭐", "🌙", "❤️"]'),

-- Grado 1 Grupo B
(2, 'Valentina', 'Pérez', '🐸', 'rana', '["🌙", "⭐", "🌸"]'),
(2, 'Andrés', 'Sánchez', '🐱', 'gato', '["❤️", "🌈", "☀️"]'),
(2, 'Isabella', 'Ramírez', '🐰', 'conejo', '["☀️", "❤️", "🌙"]'),

-- Grado 2 Grupo A
(3, 'Luciana', 'Morales', '🐸', 'rana', '["⭐", "🌸", "🌙"]'),
(3, 'Mateo', 'Jiménez', '🐱', 'gato', '["❤️", "☀️", "🌈"]'),
(3, 'Valeria', 'Ruiz', '🐰', 'conejo', '["🌙", "❤️", "⭐"]');

-- Ejemplo de inserción de estudiantes (Grados 3-5 con usuario/password)
INSERT INTO estudiantes (grupo_id, nombre, apellido, usuario, password) VALUES
-- Grado 3 Grupo A
(5, 'Daniela', 'Vega', 'daniela.vega', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'), -- password: daniela123
(5, 'Ricardo', 'Navarro', 'ricardo.navarro', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'), -- password: ricardo123
(5, 'Natalia', 'Herrera', 'natalia.herrera', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'), -- password: natalia123

-- Grado 4 Grupo A
(7, 'Andrea', 'Méndez', 'andrea.mendez', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'), -- password: andrea123
(7, 'Fernando', 'León', 'fernando.leon', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'), -- password: fernando123
(7, 'Mónica', 'Rivera', 'monica.rivera', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'); -- password: monica123

-- Vistas útiles
CREATE VIEW vista_estudiantes_completa AS
SELECT 
    e.id,
    e.nombre,
    e.apellido,
    e.usuario,
    e.personaje,
    e.personaje_nombre,
    e.password_emoji,
    g.nombre as grupo_nombre,
    gr.numero as grado_numero,
    gr.nombre as grado_nombre,
    gr.tipo_autenticacion,
    e.activo
FROM estudiantes e
JOIN grupos g ON e.grupo_id = g.id
JOIN grados gr ON g.grado_id = gr.id;

-- Índices para optimizar consultas
CREATE INDEX idx_estudiantes_grupo ON estudiantes(grupo_id);
CREATE INDEX idx_estudiantes_usuario ON estudiantes(usuario);
CREATE INDEX idx_estudiantes_activo ON estudiantes(activo);
CREATE INDEX idx_grupos_grado ON grupos(grado_id);
CREATE INDEX idx_sesiones_estudiante ON sesiones_estudiantes(estudiante_id);
CREATE INDEX idx_sesiones_token ON sesiones_estudiantes(token);
CREATE INDEX idx_sesiones_activa ON sesiones_estudiantes(activa);
