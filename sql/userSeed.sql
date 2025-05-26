USE `tfg`;

INSERT INTO
    `user` (
        `name`,
        `last_name`,
        `email`,
        `username`,
        `password`,
        `role`,
        `registration_date`
    )
VALUES
(
        'Admin',
        'Admin',
        'admin@example.com',
        'admin',
        'hashed_password_admin',
        'admin',
        NOW ()
    ), -- id 1
    (
        'Juan',
        'Pérez',
        'juan.perez@example.com',
        'juanperez',
        'hashed_password_juan',
        'user',
        NOW ()
    ), -- id 2
    (
        'María',
        'Gómez',
        'maria.gomez@example.com',
        'mariagomez',
        'hashed_password_maria',
        'user',
        NOW ()
    ), -- id 3
    (
        'Carlos',
        'López',
        'carlos.lopez@example.com',
        'carloslopez',
        'hashed_password_carlos',
        'user',
        NOW ()
    ), -- id 4
    (
        'Ana',
        'Martínez',
        'ana.martinez@example.com',
        'anamartinez',
        'hashed_password_ana',
        'user',
        NOW ()
    ); -- id 5