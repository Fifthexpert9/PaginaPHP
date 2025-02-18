<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto - Tienda Online</title>
    <style>
        .container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            margin-bottom: 2rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
            font-weight: bold;
        }

        input, textarea {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }

        textarea {
            height: 150px;
            resize: vertical;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: #666;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        button {
            width: 100%;
            padding: 1rem;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #444;
        }

    </style>
</head>
<?php require_once 'header.php'; ?>
<body>
    <div class="main-container">
        <h2>Agregar Producto</h2>
        <div class="container">
            <form action="../controllers/agregarProducto.php" method="POST">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" required>
                </div>
                <div class="form-group">
                    <label for="imagen">Imagen (URL)</label>
                    <input type="text" name="imagen" id="imagen" required>
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea name="descripcion" id="descripcion" required></textarea>
                </div>
                <div class="form-group">
                    <label for="precio">Precio (€)</label>
                    <input type="number" name="precio" id="precio" step="0.01" min="0" required>
                </div>
                <button type="submit">Agregar Producto</button>
            </form>
        </div>
    </div>
    <?php require_once 'footer.php'; ?>
</body>
</html>

