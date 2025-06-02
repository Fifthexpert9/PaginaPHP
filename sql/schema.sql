CREATE DATABASE IF NOT EXISTS `tfg`;

USE `tfg`;

CREATE TABLE
    `user` (
        `id` int (11) NOT NULL AUTO_INCREMENT,
        `name` varchar(100) NOT NULL,
        `last_name` varchar(100) NOT NULL,
        `username` varchar(50) NOT NULL UNIQUE,
        `email` varchar(100) NOT NULL UNIQUE,
        `password` varchar(255) NOT NULL,
        `role` ENUM ('admin', 'user') NOT NULL DEFAULT 'user',
        `registration_date` timestamp NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (`id`)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE
    `address` (
        `id` int (11) NOT NULL AUTO_INCREMENT,
        `street` varchar(255) NOT NULL,
        `city` varchar(100) NOT NULL,
        `province` varchar(100) DEFAULT NULL,
        `postal_code` varchar(20) NOT NULL,
        `country` varchar(100) NOT NULL,
        `latitude` decimal(10, 8) DEFAULT NULL,
        `longitude` decimal(11, 8) DEFAULT NULL,
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
        ) NOT NULL,
        `address_id` int (11) NOT NULL,
        `built_size` int (11) NOT NULL,
        `status` ENUM (
            'Obra nueva',
            'Reformado',
            'A reformar',
            'Buen estado'
        ) NOT NULL DEFAULT 'Buen estado',
        `immediate_availability` BOOLEAN NOT NULL DEFAULT 0,
        `user_id` int (11) NOT NULL,
        PRIMARY KEY (`id`),
        FOREIGN KEY (`address_id`) REFERENCES `address` (`id`) ON DELETE CASCADE,
        FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE
    `property_image` (
        `id` int (11) NOT NULL AUTO_INCREMENT,
        `property_id` int (11) NOT NULL,
        `image_path` varchar(255) NOT NULL,
        `is_main` BOOLEAN DEFAULT 0,
        `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (`id`),
        FOREIGN KEY (`property_id`) REFERENCES `property` (`id`) ON DELETE CASCADE
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE
    `property_room` (
        `property_id` int (11) NOT NULL,
        `private_bathroom` BOOLEAN NOT NULL DEFAULT 0,
        `max_roommates` int (11) NOT NULL,
        `pets_allowed` BOOLEAN NOT NULL DEFAULT 0,
        `furnished` BOOLEAN NOT NULL DEFAULT 0,
        `students_only` BOOLEAN NOT NULL DEFAULT 0,
        `gender_restriction` ENUM ('Sin restricciones', 'Sólo chicos', 'Sólo chicas') NOT NULL DEFAULT 'Sin restricciones',
        PRIMARY KEY (`property_id`),
        FOREIGN KEY (`property_id`) REFERENCES `property` (`id`) ON DELETE CASCADE
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE
    `property_studio` (
        `property_id` int (11) NOT NULL,
        `furnished` BOOLEAN NOT NULL DEFAULT 0,
        `balcony` BOOLEAN NOT NULL DEFAULT 0,
        `air_conditioning` BOOLEAN NOT NULL DEFAULT 0,
        `pets_allowed` BOOLEAN NOT NULL DEFAULT 0,
        PRIMARY KEY (`property_id`),
        FOREIGN KEY (`property_id`) REFERENCES `property` (`id`) ON DELETE CASCADE
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE
    `property_apartment` (
        `property_id` int (11) NOT NULL,
        `apartment_type` ENUM ('Estándar', 'Loft', 'Ático', 'Dúplex', 'Bajo con jardín') NOT NULL DEFAULT 'Estándar',
        `num_rooms` int (11) NOT NULL,
        `num_bathrooms` int (11) NOT NULL,
        `furnished` BOOLEAN NOT NULL DEFAULT 0,
        `balcony` BOOLEAN NOT NULL DEFAULT 0,
        `floor` int (11) NOT NULL,
        `elevator` BOOLEAN NOT NULL DEFAULT 0,
        `air_conditioning` BOOLEAN NOT NULL DEFAULT 0,
        `garage` BOOLEAN NOT NULL DEFAULT 0,
        `pets_allowed` BOOLEAN NOT NULL DEFAULT 0,
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
        ) NOT NULL,
        `garden_size` int (11) NOT NULL,
        `num_floors` int (11) NOT NULL,
        `num_rooms` int (11) NOT NULL,
        `num_bathrooms` int (11) NOT NULL,
        `private_garage` BOOLEAN NOT NULL DEFAULT 0,
        `private_pool` BOOLEAN NOT NULL DEFAULT 0,
        `furnished` BOOLEAN NOT NULL DEFAULT 0,
        `terrace` BOOLEAN NOT NULL DEFAULT 0,
        `storage_room` BOOLEAN NOT NULL DEFAULT 0,
        `air_conditioning` BOOLEAN NOT NULL DEFAULT 0,
        `pets_allowed` BOOLEAN NOT NULL DEFAULT 0,
        PRIMARY KEY (`property_id`),
        FOREIGN KEY (`property_id`) REFERENCES `property` (`id`) ON DELETE CASCADE
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE
    `advert` (
        `id` int (11) NOT NULL AUTO_INCREMENT,
        `property_id` int (11) NOT NULL,
        `user_id` int (11) NOT NULL,
        `price` decimal(10, 2) NOT NULL,
        `action` ENUM (
            'Venta',
            'Alquiler'
        ) NOT NULL,
        `description` text NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (`id`),
        FOREIGN KEY (`property_id`) REFERENCES `property` (`id`) ON DELETE CASCADE,
        FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE
    `favorites` (
        `id` int (11) NOT NULL AUTO_INCREMENT,
        `user_id` int (11) NOT NULL,
        `advert_id` int (11) NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (`id`),
        FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
        FOREIGN KEY (`advert_id`) REFERENCES `advert` (`id`) ON DELETE CASCADE
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE
    `message` (
        `id` int (11) NOT NULL AUTO_INCREMENT,
        `sender_id` int (11) NOT NULL,
        `receiver_id` int (11) NOT NULL,
        `advert_id` int (11) DEFAULT NULL,
        `subject` varchar(255) NOT NULL,
        `content` text NOT NULL,
        `sent_at` timestamp NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (`id`),
        FOREIGN KEY (`sender_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
        FOREIGN KEY (`receiver_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
        FOREIGN KEY (`advert_id`) REFERENCES `advert` (`id`) ON DELETE CASCADE
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;