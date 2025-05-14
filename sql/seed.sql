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
        'Juan',
        'Pérez',
        'juan.perez@example.com',
        'juanperez',
        'hashed_password_juan',
        'user',
        NOW ()
    ),
    (
        'María',
        'Gómez',
        'maria.gomez@example.com',
        'mariagomez',
        'hashed_password_maria',
        'user',
        NOW ()
    ),
    (
        'Carlos',
        'López',
        'carlos.lopez@example.com',
        'carloslopez',
        'hashed_password_carlos',
        'user',
        NOW ()
    ),
    (
        'Ana',
        'Martínez',
        'ana.martinez@example.com',
        'anamartinez',
        'hashed_password_ana',
        'user',
        NOW ()
    ),
    (
        'Admin',
        'Admin',
        'admin@example.com',
        'admin',
        'hashed_password_admin',
        'admin',
        NOW ()
    );