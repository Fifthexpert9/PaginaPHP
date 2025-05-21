CREATE DATABASE IF NOT EXISTS `tfg` DEFAULT CHARACTER
SET
    utf8mb4 COLLATE utf8mb4_general_ci;

USE `tfg`;

CREATE TABLE
    `user` (
        `id` int (11) NOT NULL AUTO_INCREMENT,
        `name` varchar(100) NOT NULL,
        `last_name` varchar(100) NOT NULL,
        `username` varchar(50) NOT NULL UNIQUE,
        `email` varchar(100) NOT NULL UNIQUE,
        `password` varchar(255) NOT NULL,
        `role` ENUM ('admin', 'user') NOT NULL DEFAULT 'user', -- Rol del usuario
        `registration_date` timestamp NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (`id`)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE
    `address` (
        `id` int (11) NOT NULL AUTO_INCREMENT,
        `street` varchar(255) NOT NULL, -- Calle y número
        `city` varchar(100) NOT NULL, -- Ciudad
        `province` varchar(100) DEFAULT NULL, -- Provincia
        `postal_code` varchar(20) NOT NULL, -- Código postal
        `country` varchar(100) NOT NULL, -- País
        `latitude` decimal(10, 8) DEFAULT NULL, -- Coordenadas (opcional)
        `longitude` decimal(11, 8) DEFAULT NULL, -- Coordenadas (opcional)
        PRIMARY KEY (`id`)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE
    `property` (
        `id` int (11) NOT NULL AUTO_INCREMENT,
        `property_type` ENUM (
            'Habitación',
            'Estudio',
            'Piso',
            'Casa'
            --,'Mansión'
        ) NOT NULL, -- Tipo de propiedad
        `address_id` int (11) NOT NULL, -- Relación con la tabla address
        `built_size` int (11) DEFAULT NULL, -- Superficie construida (m²)
        `price` decimal(10, 2) NOT NULL, -- Precio
        `status` ENUM (
            'Obra nueva',
            'Reformado',
            'A reformar',
            'Buen estado'
        ) NOT NULL, -- Estado del inmueble
        `immediate_availability` BOOLEAN NOT NULL DEFAULT 0, -- Disponibilidad inmediata (Sí/No)
        `user_id` int (11) NOT NULL, -- Usuario que registró la propiedad
        PRIMARY KEY (`id`),
        FOREIGN KEY (`address_id`) REFERENCES `address` (`id`) ON DELETE CASCADE,
        FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE
    `property_image` (
        `id` int (11) NOT NULL AUTO_INCREMENT, -- ID único de la imagen
        `property_id` int (11) NOT NULL, -- Relación con la propiedad
        `image_path` varchar(255) NOT NULL, -- Ruta o URL de la imagen
        `is_main` BOOLEAN DEFAULT 0, -- Indica si es la imagen principal (Sí/No)
        `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(), -- Fecha de subida
        PRIMARY KEY (`id`),
        FOREIGN KEY (`property_id`) REFERENCES `property` (`id`) ON DELETE CASCADE -- Relación con la tabla property
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE
    `property_room` (
        `property_id` int (11) NOT NULL,
        `private_bathroom` BOOLEAN DEFAULT NULL, -- ¿Baño privado? (Sí/No)
        -- `room_size` int (11) DEFAULT NULL, -- Tamaño de la habitación (m²)
        `max_roommates` int (11) DEFAULT NULL, -- Número máximo de compañeros de piso
        -- `includes_expenses` BOOLEAN DEFAULT NULL, -- ¿Incluye gastos en el precio? (Sí/No)
        `pets_allowed` BOOLEAN DEFAULT NULL, -- ¿Se permiten mascotas? (Sí/No)
        `furnished` BOOLEAN DEFAULT NULL, -- ¿Está amueblada? (Sí/No)
        -- `common_areas` BOOLEAN DEFAULT NULL, -- ¿Uso de zonas comunes? (Sí/No)
        `students_only` BOOLEAN DEFAULT NULL, -- ¿Estudiantes únicamente? (Sí/No)
        `gender_restriction` ENUM ('None', 'Only males', 'Only females') DEFAULT 'None', -- ¿Solo chicas/chicos?
        PRIMARY KEY (`property_id`),
        FOREIGN KEY (`property_id`) REFERENCES `property` (`id`) ON DELETE CASCADE
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE
    `property_studio` (
        `property_id` int (11) NOT NULL,
        `furnished` BOOLEAN DEFAULT NULL, -- ¿Amueblado? (Sí/No)
        `balcony` BOOLEAN DEFAULT NULL, -- ¿Tiene balcón o terraza? (Sí/No)
        `air_conditioning` BOOLEAN DEFAULT NULL, -- ¿Aire acondicionado? (Sí/No)
        `pets_allowed` BOOLEAN DEFAULT NULL, -- ¿Se permiten mascotas? (Sí/No)
        PRIMARY KEY (`property_id`),
        FOREIGN KEY (`property_id`) REFERENCES `property` (`id`) ON DELETE CASCADE
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE
    `property_apartment` (
        `property_id` int (11) NOT NULL,
        `apartment_type` ENUM ('Loft', 'Ático', 'Dúplex', 'Bajo con jardín') NOT NULL, -- Tipo de apartamento
        `num_rooms` int (11) DEFAULT NULL, -- Número de habitaciones
        `num_bathrooms` int (11) DEFAULT NULL, -- Número de baños
        `furnished` BOOLEAN DEFAULT NULL, -- ¿Amueblado? (Sí/No)
        `balcony` BOOLEAN DEFAULT NULL, -- ¿Tiene balcón o terraza? (Sí/No)
        `floor` int (11) DEFAULT NULL, -- ¿Planta?
        `elevator` BOOLEAN DEFAULT NULL, -- ¿Ascensor? (Sí/No)
        `air_conditioning` BOOLEAN DEFAULT NULL, -- ¿Aire acondicionado? (Sí/No)
        `garage` BOOLEAN DEFAULT NULL, -- ¿Garaje? (Sí/No)
        -- `pool` BOOLEAN DEFAULT NULL, -- ¿Piscina comunitaria? (Sí/No)
        `pets_allowed` BOOLEAN DEFAULT NULL, -- ¿Se permiten mascotas? (Sí/No)
        PRIMARY KEY (`property_id`),
        FOREIGN KEY (`property_id`) REFERENCES `property` (`id`) ON DELETE CASCADE
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE
    `property_house` (
        `property_id` int (11) NOT NULL,
        `house_type` ENUM (
            'Unifamiliar',
            'Chalet',
            'Adosado',
            'Pareado',
            'Casa rural'
        ) NOT NULL, -- Tipo de casa
        `garden_size` int (11) DEFAULT NULL, -- Superficie del terreno o jardín (m²)
        `num_floors` int (11) DEFAULT NULL, -- Número de plantas
        `num_rooms` int (11) DEFAULT NULL, -- Número de habitaciones
        `num_bathrooms` int (11) DEFAULT NULL, -- Número de baños
        `private_garage` BOOLEAN DEFAULT NULL, -- ¿Garaje privado? (Sí/No)
        `private_pool` BOOLEAN DEFAULT NULL, -- ¿Piscina privada? (Sí/No)
        `furnished` BOOLEAN DEFAULT NULL, -- ¿Amueblada? (Sí/No)
        `terrace` BOOLEAN DEFAULT NULL, -- ¿Terraza o porche? (Sí/No)
        `storage_room` BOOLEAN DEFAULT NULL, -- ¿Trastero? (Sí/No)
        `air_conditioning` BOOLEAN DEFAULT NULL, -- ¿Aire acondicionado o calefacción? (Sí/No)
        `pets_allowed` BOOLEAN DEFAULT NULL, -- ¿Se permiten mascotas? (Sí/No)
        PRIMARY KEY (`property_id`),
        FOREIGN KEY (`property_id`) REFERENCES `property` (`id`) ON DELETE CASCADE
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*
CREATE TABLE
    `property_mansion` (
        `property_id` int (11) NOT NULL,
        `plot_size` int (11) DEFAULT NULL, -- Superficie de la parcela (m²)
        `num_rooms` int (11) DEFAULT NULL, -- Número de habitaciones
        `num_bathrooms` int (11) DEFAULT NULL, -- Número de baños
        `pool` BOOLEAN DEFAULT NULL, -- ¿Piscina? (Sí/No)
        `gym` BOOLEAN DEFAULT NULL, -- ¿Gimnasio / Spa? (Sí/No)
        `cinema_room` BOOLEAN DEFAULT NULL, -- ¿Sala de cine / ocio? (Sí/No)
        `security` BOOLEAN DEFAULT NULL, -- ¿Seguridad privada? (Sí/No)
        `home_automation` BOOLEAN DEFAULT NULL, -- ¿Domótica integrada? (Sí/No)
        `garage_capacity` int (11) DEFAULT NULL, -- Capacidad del garaje
        `views` ENUM ('Mar', 'Montaña', 'Ciudad', 'Campo') DEFAULT NULL, -- Tipo de vistas
        PRIMARY KEY (`property_id`),
        FOREIGN KEY (`property_id`) REFERENCES `property` (`id`) ON DELETE CASCADE
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
*/

CREATE TABLE
    `advert` (
        `id` int (11) NOT NULL AUTO_INCREMENT,
        `property_id` int (11) NOT NULL, -- Relación con la propiedad
        `user_id` int (11) NOT NULL, -- Usuario que publica el anuncio
        `price` decimal(10, 2) NOT NULL,
        `action` ENUM (
            'Venta',
            'Alquiler'
        ) NOT NULL, -- Tipo de acción
        `description` text NOT NULL, -- Descripción del anuncio
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (`id`),
        FOREIGN KEY (`property_id`) REFERENCES `property` (`id`) ON DELETE CASCADE,
        FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE
    `favorites` (
        `id` int (11) NOT NULL AUTO_INCREMENT,
        `user_id` int (11) NOT NULL, -- Usuario que guarda el anuncio como favorito
        `advert_id` int (11) NOT NULL, -- Anuncio marcado como favorito
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(), -- Fecha en que se marcó como favorito
        PRIMARY KEY (`id`),
        FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
        FOREIGN KEY (`advert_id`) REFERENCES `advert` (`id`) ON DELETE CASCADE
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE
    `message` (
        `id` int (11) NOT NULL AUTO_INCREMENT, -- ID único del mensaje
        `sender_id` int (11) NOT NULL, -- Usuario que envía el mensaje
        `receiver_id` int (11) NOT NULL, -- Usuario que recibe el mensaje
        `advert_id` int (11) DEFAULT NULL, -- Anuncio relacionada (opcional)
        `subject` varchar(255) NOT NULL, -- Asunto del mensaje
        `content` text NOT NULL, -- Contenido del mensaje
        `sent_at` timestamp NOT NULL DEFAULT current_timestamp(), -- Fecha y hora de envío
        PRIMARY KEY (`id`),
        FOREIGN KEY (`sender_id`) REFERENCES `user` (`id`) ON DELETE CASCADE, -- Relación con el usuario remitente
        FOREIGN KEY (`receiver_id`) REFERENCES `user` (`id`) ON DELETE CASCADE, -- Relación con el usuario destinatario
        FOREIGN KEY (`advert_id`) REFERENCES `advert` (`id`) ON DELETE CASCADE -- Relación con el anuncio
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;