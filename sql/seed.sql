USE `tfg`;

INSERT INTO `user` (`name`, `last_name`, `username`, `email`, `password`, `role`)
VALUES
    ('Admin', 'Admin', 'admin','admin@example.com', 'hashed_password_admin', 'admin'), -- id 1
    ('Juan', 'Pérez', 'juan','juan.perez@example.com', 'hashed_password_juan', 'user'), -- id 2
    ('María', 'Gómez', 'maria','maria.gomez@example.com', 'hashed_password_maria', 'user'), -- id 3
    ('Carlos', 'López', 'carlos','carlos.lopez@example.com', 'hashed_password_carlos', 'user'), -- id 4
    ('Ana', 'Martínez', 'ana','ana.martinez@example.com', 'hashed_password_ana', 'user'); -- id 5

INSERT INTO `address` (`street`, `city`, `province`, `postal_code`, `country`, `latitude`, `longitude`)
VALUES
    ('Calle Mayor 1', 'Madrid', 'Madrid', '28013', 'España', 40.416775, -3.703790), -- id 1
    ('Avenida Diagonal 123', 'Barcelona', 'Barcelona', '08008', 'España', 41.391730, 2.165640), -- id 2
    ('Calle Larios 5', 'Málaga', 'Málaga', '29015', 'España', 36.720160, -4.420340), -- id 3
    ('Gran Vía 45', 'Bilbao', 'Bizkaia', '48011', 'España', 43.263013, -2.934985), -- id 4
    ('Calle Colón 10', 'Valencia', 'Valencia', '46004', 'España', 39.469907, -0.376288),-- id 5
    ('Paseo de Zorrilla 50', 'Valladolid', 'Valladolid', '47007', 'España', 41.629445, -4.728679), -- id 6
    ('Calle San Fernando 22', 'Santander', 'Cantabria', '39010', 'España', 43.462305, -3.809980), -- id 7
    ('Avenida de la Constitución 18', 'Sevilla', 'Sevilla', '41004', 'España', 37.388630, -5.995340), -- id 8
    ('Calle Uría 25', 'Oviedo', 'Asturias', '33003', 'España', 43.362343, -5.848876), -- id 9
    ('Calle Real 77', 'A Coruña', 'A Coruña', '15003', 'España', 43.370873, -8.395835), -- id 10
    ('Calle Gran Capitán 12', 'Granada', 'Granada', '18002', 'España', 37.176487, -3.597929), -- id 11
    ('Calle Alfonso I 15', 'Zaragoza', 'Zaragoza', '50003', 'España', 41.656806, -0.877339), -- id 12
    ('Calle Menéndez Pelayo 8', 'Salamanca', 'Salamanca', '37007', 'España', 40.965157, -5.663539), -- id 13
    ('Calle Mayor 20', 'Alicante', 'Alicante', '03002', 'España', 38.345170, -0.481490), -- id 14
    ('Calle San Vicente 33', 'Murcia', 'Murcia', '30001', 'España', 37.983444, -1.129889), -- id 15
    ('Calle Ancha 14', 'Cádiz', 'Cádiz', '11001', 'España', 36.529770, -6.292470), -- id 16
    ('Calle Castillo 9', 'Santa Cruz de Tenerife', 'Santa Cruz de Tenerife', '38002', 'España', 28.463630, -16.251847); -- id 17

INSERT INTO `property` (`property_type`, `address_id`, `built_size`, `status`, `immediate_availability`, `user_id`)
VALUES
    ('Estudio', 6, 28, 'Reformado', 1, 3), -- id 1
    ('Habitación', 1, 12, 'Buen estado', 1, 2), -- id 2
    ('Casa', 15, 135, 'Buen estado', 0, 4), -- id 3
    ('Habitación', 4, 11, 'Obra nueva', 1, 5), -- id 4
    ('Piso', 9, 75, 'Buen estado', 1, 2), -- id 5
    ('Piso', 11, 80, 'Buen estado', 0, 4), -- id 6
    ('Habitación', 2, 10, 'Reformado', 1, 3), -- id 7
    ('Casa', 16, 140, 'Reformado', 1, 5), -- id 8
    ('Casa', 14, 150, 'Obra nueva', 1, 3), -- id 9
    ('Habitación', 3, 14, 'Buen estado', 0, 4), -- id 10
    ('Piso', 10, 90, 'Reformado', 1, 3), -- id 11
    ('Estudio', 8, 30, 'Buen estado', 0, 5), -- id 12
    ('Piso', 12, 85, 'A reformar', 0, 5), -- id 13
    ('Casa', 13, 120, 'Buen estado', 1, 2), -- id 14
    ('Estudio', 7, 25, 'Buen estado', 1, 4), -- id 15
    ('Casa', 17, 160, 'Buen estado', 0, 2), -- id 16
    ('Habitación', 5, 13, 'Buen estado', 0, 2); -- id 17

INSERT INTO `property_image` (`property_id`, `image_path`, `is_main`)
VALUES
    (1, 'media/prop1_main.jpg', 1),
    (1, 'media/prop1_2.jpg', 0),
    (2, 'media/prop2_main.jpg', 1),
    (2, 'media/prop2_2.jpg', 0),
    (3, 'media/prop3_main.jpg', 1),
    (3, 'media/prop3_2.jpg', 0),
    (4, 'media/prop4_main.jpg', 1),
    (4, 'media/prop4_2.jpg', 0),
    (5, 'media/prop5_main.jpg', 1),
    (5, 'media/prop5_2.jpg', 0),
    (6, 'media/prop6_main.jpg', 1),
    (6, 'media/prop6_2.jpg', 0),
    (7, 'media/prop7_main.jpg', 1),
    (7, 'media/prop7_2.jpg', 0),
    (8, 'media/prop8_main.jpg', 1),
    (8, 'media/prop8_2.jpg', 0),
    (9, 'media/prop9_main.jpg', 1),
    (9, 'media/prop9_2.jpg', 0),
    (10, 'media/prop10_main.jpg', 1),
    (10, 'media/prop10_2.jpg', 0),
    (11, 'media/prop11_main.jpg', 1),
    (11, 'media/prop11_2.jpg', 0),
    (12, 'media/prop12_main.jpg', 1),
    (12, 'media/prop12_2.jpg', 0),
    (13, 'media/prop13_main.jpg', 1),
    (13, 'media/prop13_2.jpg', 0),
    (14, 'media/prop14_main.jpg', 1),
    (14, 'media/prop14_2.jpg', 0),
    (15, 'media/prop15_main.jpg', 1),
    (15, 'media/prop15_2.jpg', 0),
    (16, 'media/prop16_main.jpg', 1),
    (16, 'media/prop16_2.jpg', 0),
    (17, 'media/prop17_main.jpg', 1),
    (17, 'media/prop17_2.jpg', 0);

INSERT INTO `advert` (`property_id`, `user_id`, `price`, `action`, `description`)
VALUES
    (7, 2, 280.00, 'Alquiler', 'Habitación para estudiantes en Valencia, cerca de la universidad.'),
    (4, 2, 350.00, 'Alquiler', 'Habitación luminosa en el centro de Madrid, cerca de todos los servicios.'),
    (2, 5, 400.00, 'Alquiler', 'Habitación acogedora en piso céntrico de Bilbao.'),
    (17, 3, 320.00, 'Alquiler', 'Habitación individual en piso compartido en Barcelona.'),
    (10, 4, 300.00, 'Alquiler', 'Habitación amplia con baño privado en Málaga.'),
    (15, 4, 550.00, 'Alquiler', 'Estudio a las afueras Santander, ideal para una persona.'),
    (12, 3, 600.00, 'Alquiler', 'Estudio moderno y equipado en Valladolid.'),
    (1, 5, 580.00, 'Alquiler', 'Estudio para músicos en Sevilla, muy luminoso.'),
    (13, 2, 950.00, 'Alquiler', 'Piso de 3 habitaciones en Oviedo, perfecto para familias.'),
    (11, 5, 90000.00, 'Venta', 'Piso amplio en Zaragoza, zona tranquila y bien comunicada.'),
    (6, 4, 110000.00, 'Alquiler', 'Piso céntrico en Granada, con balcón y buenas vistas.'),
    (5, 3, 120000.00, 'Venta', 'Piso reformado en A Coruña, cerca de la playa.'),
    (3, 2, 180000.00, 'Venta', 'Casa independiente en Salamanca con jardín privado.'),
    (14, 3, 250000.00, 'Alquiler', 'Casa moderna en Alicante, piscina y garaje.'),
    (8, 2, 240000.00, 'Venta', 'Casa espaciosa en Santa Cruz de Tenerife, vistas al mar.'),
    (16, 5, 220000.00, 'Alquiler', 'Casa tradicional en Cádiz, patio andaluz.'),
    (9, 4, 200000.00, 'Venta', 'Casa familiar en Murcia, cerca de colegios y parques.');

INSERT INTO `property_room` (`property_id`, `private_bathroom`, `max_roommates`, `pets_allowed`, `furnished`, `students_only`, `gender_restriction`)
VALUES
    (2, 0, 3, 0, 1, 0, 'Sin restricciones'), -- Habitación en Bilbao
    (4, 0, 1, 1, 1, 0, 'Sin restricciones'), -- Habitación en Madrid
    (7, 0, 3, 0, 0, 1, 'Sólo chicos'), -- Habitación en Valencia
    (10, 1, 2, 1, 0, 0, 'Sin restricciones'), -- Habitación en Málaga
    (17, 1, 1, 0, 1, 0, 'Sólo chicas'); -- Habitación en Barcelona

INSERT INTO `property_studio` (`property_id`, `furnished`, `balcony`, `air_conditioning`, `pets_allowed`)
VALUES
    (1, 1, 0, 1, 1), -- Estudio en Sevilla
    (12, 0, 0, 1, 1), -- Estudio en Valladolid
    (15, 1, 0, 1, 1); -- Estudio en Santander

INSERT INTO `property_apartment` (`property_id`, `apartment_type`, `num_rooms`, `num_bathrooms`, `furnished`, `balcony`, `floor`, `elevator`, `air_conditioning`, `garage`, `pets_allowed`)
VALUES
    (5, 'Estándar',  3, 2, 0, 1, 0, 0, 1, 1, 0), -- Piso en A Coruña
    (6, 'Ático', 4, 3, 1, 1, 3, 0, 0, 0, 1), -- Piso en Granada
    (11, 'Dúplex', 3, 3, 0, 0, 2, 1, 1, 0, 1), -- Piso en Zaragoza
    (13, 'Bajo con jardín', 3, 1, 0, 1, 0, 0, 1, 1, 0); -- Piso en Oviedo

INSERT INTO `property_house` (`property_id`, `house_type`, `garden_size`, `num_floors`, `num_rooms`, `num_bathrooms`, `private_garage`, `private_pool`, `furnished`, `terrace`, `storage_room`, `air_conditioning`, `pets_allowed`)
VALUES
    (3, 'Chalet', 170, 1, 4, 2, 0, 0, 0, 1, 0, 0, 1), -- Casa en Salamanca
    (8, 'Chalet', 220, 3, 6, 5, 1, 1, 0, 1, 1, 1, 1), -- Casa en Santa Cruz de Tenerife
    (9, 'Unifamiliar', 50, 1, 4, 2, 0, 0, 0, 1, 1, 0, 1), -- Casa en Murcia
    (14, 'Chalet', 300, 2, 7, 9, 1, 1, 0, 1, 1, 1, 0), -- Casa en Alicante
    (16, 'Adosado', 20, 2, 4, 3, 0, 1, 1, 1, 0, 0, 1); -- Casa en Cádiz