use soreweb;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    correo VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    activo BOOLEAN DEFAULT TRUE,
    rol char(1) DEFAULT "U"
);

CREATE TABLE juegos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT NOT NULL,
    imagen VARCHAR(255),
    horas INT,
    dificultad VARCHAR(50),
    estado VARCHAR(50),
    rating DECIMAL(2,1),
    rating_custom VARCHAR(255),
    creado_en DATETIME DEFAULT CURRENT_TIMESTAMP
);

select * from usuarios;
select * from juegos;
update usuarios set rol='A' where id="1";