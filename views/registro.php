<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Tienda Online</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .container {
            max-width: 2000px;
            margin: 0 auto;
            padding: 1rem;
        }

        .registro-form {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            margin: 2rem auto;
        }

        .registro-form h2 {
            text-align: center;
            margin-bottom: 2rem;
            color: #333;
        }

        .form-group {
            margin-bottom: 1.5rem;

            p{
                color: red;
                display: none;
            };
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .form-group input {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }

        .form-group input:focus {
            outline: none;
            border-color: #666;
        }

        button {
            width: 100%;
            padding: 1rem;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }

        button:hover {
            background-color: #444;
        }

        .login-link {
            text-align: center;
            margin-top: 1rem;
        }

        .login-link a {
            color: blue;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<?php include 'header.php'; ?>

<body>
    <div class="container">
        <div class="registro-form">
            <h2>Crear Cuenta</h2>
            <form action="../controllers/procesar_registro.php" method="POST">
                <div class="form-group">
                    <label for="nombre">Nombre completo</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirmar contraseña</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                    <br><br>
                    <p>Las contraseñas no coinciden</p>
                </div>
                
                <button type="submit">Registrarse</button>
            </form>
            
            <div class="login-link">
                <p>¿Ya tienes una cuenta? <a href="/login">Iniciar Sesión</a></p>
            </div>
        </div>
    </div>

    <script>
        const contrasena = document.getElementById('password');
        const contraConfirm = document.getElementById('confirm_password');
        const enviar = document.querySelector('button');
        const mensaje = document.querySelector('.form-group p');

        enviar.addEventListener('click', (e) => {
            if (contrasena.value !== contraConfirm.value) {
                e.preventDefault();
                contrasena.style.borderColor = 'red';
                contraConfirm.style.borderColor = 'red';
                mensaje.style.display = 'block';    
            }
        });

        contrasena.addEventListener('focus', () => {
            // Resetear estilos cuando se enfoca en la contraseña
            contrasena.style.borderColor = '#ddd';
            contraConfirm.style.borderColor = '#ddd';
            contrasena.value = ''; // Limpiar el campo de contraseña
            contraConfirm.value = ''; // Limpiar el campo de confirmación
            mensaje.style.display = 'none'; // Ocultar mensaje de error
        });
    </script>
</body>
</html>