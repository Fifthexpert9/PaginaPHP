USE tfg;

INSERT INTO property (property_type, address_id, built_size, status, immediate_availability, user_id) VALUES
-- Habitaciones (5)
('Habitación', 1, 12, 'Buen estado', 1, 2),
('Habitación', 2, 10, 'Reformado', 1, 3),
('Habitación', 3, 14, 'Buen estado', 0, 4),
('Habitación', 4, 11, 'Obra nueva', 1, 5),
('Habitación', 5, 13, 'Buen estado', 0, 2),

-- Estudios (3)
('Estudio', 6, 28, 'Reformado', 1, 3),
('Estudio', 7, 25, 'Buen estado', 1, 4),
('Estudio', 8, 30, 'Buen estado', 0, 5),

-- Pisos (4)
('Piso', 9, 75, 'Buen estado', 1, 2),
('Piso', 10, 90, 'Reformado', 1, 3),
('Piso', 11, 80, 'Buen estado', 0, 4),
('Piso', 12, 85, 'A reformar', 0, 5),

-- Casas (5)
('Casa', 13, 120, 'Buen estado', 1, 2),
('Casa', 14, 150, 'Obra nueva', 1, 3),
('Casa', 15, 135, 'Buen estado', 0, 4),
('Casa', 16, 140, 'Reformado', 1, 5),
('Casa', 17, 160, 'Buen estado', 0, 2);