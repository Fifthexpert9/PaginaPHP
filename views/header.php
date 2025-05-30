<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../models/user.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tienda Online</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      text-decoration: none;
    }

    body {
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
      color: #333;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    header, footer {
      background-color: #333;
      color: white;
      padding: 1rem;
    }

    header a {
      color: white;
      text-decoration: none;
    }

    nav {
      display: flex;
      align-items: center;
    }

    nav ul {
      display: flex;
      list-style: none;
      gap: 1rem;
      align-items: center; /* Alinea verticalmente todos los elementos */
    }
    nav a {
      color: white;
      text-decoration: none;
      display: flex;
      align-items: center;
      height: 100%;
      padding: 0.5rem 1rem;
    }
    nav a:hover {
      text-decoration: underline;
    }
    .main-container {
      max-width: 800px;
      margin: 2rem auto;
      padding: 2rem;
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    main {
      padding: 2rem 0;
      text-align: center;
      flex: 1;
    }
    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 1.5rem;
    }
    .card {
      background-color: #fff;
      padding: 1rem;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .card h2 {
      font-size: 1.25rem;
      margin-bottom: 0.5rem;
    }
    .card a {
      color: blue;
      text-decoration: none;
    }
    .card a:hover {
      text-decoration: underline;
    }
    .card img {
      width: 100%;
      height: 200px; /* Altura fija para todas las imágenes */
      object-fit: cover; /* Mantiene la proporción y cubre el espacio */
      object-position: center; /* Centra la imagen */
      margin-bottom: 1rem;
      border-radius: 4px; /* Opcional: para bordes redondeados */
    }
    .precio {
      font-weight: bold;
      color: #333;
      font-size: 1.2rem;
      margin: 0.5rem 0;
    }
    footer {
      text-align: center;
    }
    .overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 1000;
    }

    .login-form {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: white;
      padding: 2rem;
      border-radius: 8px;
      width: 90%;
      max-width: 400px;
      z-index: 1001;
    }

    .login-form h2 {
      margin-bottom: 2rem;
    } 

    form p {
      font-size: smaller;

      a{
        color: blue;
        text-decoration: none;
      }

      a:hover{
          text-decoration: underline;
        }
    } 

    .close-btn {
      position: absolute;
      right: 1rem;
      top: 0.5rem;
      font-size: 1.5rem;
      cursor: pointer;
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    .form-group input {
      width: 100%;
      padding: 0.5rem;
      border: 1px solid #ddd;
      border-radius: 4px;
    }

    .login-form button {
      width: 100%;
      padding: 0.5rem;
      background-color: #333;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .login-form button:hover {
      background-color: #444;
    }

    h2 {
      color: #333;
      margin-bottom: 2rem;
      text-align: center;
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

    /* Modificar el contenedor del header */
    header .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 1rem;
        background-color: transparent;
        box-shadow: none;
    }

    /* Eliminar el estilo general de .container */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 1rem;
    }

    /* Estilos específicos para header y footer */
    header .container, 
    footer .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 1rem;
        background-color: transparent;
        box-shadow: none;
    }

    /* Contenedor principal para formularios y contenido */
    .main-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 2rem;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Estilos para el usuario y cerrar sesión */
    .user-welcome, 
    .logout-btn {
        display: flex;
        align-items: center;
    }

    .user-name {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        background-color: rgba(255, 255, 255, 0.1);
        transition: background-color 0.3s ease;
    }

    .user-name:hover {
        background-color: rgba(255, 255, 255, 0.2);
        text-decoration: none;
    }

    .logout-btn {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        background-color: #dc3545;
        transition: background-color 0.3s ease;
    }

    .logout-btn:hover {
        background-color: #c82333;
        text-decoration: none;
    }

    .material-icons {
        font-size: 20px;
        margin-right: 0.3rem;
    }

    /* Asegurar que todos los elementos del nav tengan la misma altura */
    nav li {
        display: flex;
        align-items: center;
        height: 100%;
    }

    /* Estilos para el botón de inicio de sesión en el nav */
    #loginBtn {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        background-color: #007bff;
        color: white;
        transition: background-color 0.3s ease;
    }

    #loginBtn:hover {
        background-color: #0056b3;
        text-decoration: none;
    }

    #loginBtn::before {
        content: 'login';
        font-family: 'Material Icons';
        font-size: 20px;
    }

    /* Estilos para los botones de inicio de sesión en las tarjetas de productos */
    .card .login-card-btn {
        display: inline-block;
        padding: 0.5rem 1rem;
        background-color: #007bff;
        color: white;
        border-radius: 4px;
        margin-top: 1rem;
        transition: background-color 0.3s ease;
    }

    .card .login-card-btn:hover {
        background-color: #0056b3;
        text-decoration: none;
    }

    .card .login-card-btn i {
        vertical-align: middle;
        margin-right: 0.3rem;
    }

        /* Layout general: filtros a la izquierda, productos a la derecha */
    .shop-layout {
      display: flex;
      gap: 2rem;
      padding: 2rem;
    }

    /* Formulario de filtrado */
    .filter-form {
      width: 250px;
      background-color: #ffffff;
      border-radius: 8px;
      padding: 1.5rem;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
      height: fit-content;
    }

    .filter-form h3 {
      margin-bottom: 1rem;
      font-size: 1.2rem;
      color: #333;
    }

    .filter-form label {
      font-weight: 600;
      display: block;
      margin-top: 1rem;
      margin-bottom: 0.3rem;
      color: #555;
    }

    .filter-form input,
    .filter-form select {
      width: 100%;
      padding: 0.6rem;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 0.95rem;
    }

    .filter-form button {
      margin-top: 1.5rem;
      width: 100%;
      background-color: #28a745;
      color: white;
      padding: 0.7rem;
      font-weight: bold;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .filter-form button:hover {
      background-color: #218838;
    }

    /* Contenedor de productos */
    .productos-grid {
      flex: 1;
    }

    /* Mejora para las tarjetas */
    .card {
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
      transform: translateY(-4px);
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

  </style>
</head>
<body>
<header>
  <div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center;">
      <a href="/" style="font-size: 1.5rem; font-weight: bold;">Tienda Online</a>
      <nav>
        <ul>
          <li><a href="/">Inicio</a></li>
          <li><a href="/productos">Productos</a></li>
          <li><a href="#">Contacto</a></li>
          <?php if (isset($_SESSION['usuario'])): ?>
            <?php 
                $usuario = unserialize($_SESSION['usuario']);
            ?>
            <li class="user-welcome">
                <a href="#" class="user-name">
                    <i class="material-icons">account_circle</i>
                    <?php echo htmlspecialchars($usuario->getNombre()); ?>
                </a>
            </li>
            <li>
                <a href="controllers/cerrarSesion.php" class="logout-btn">
                    <i class="material-icons">logout</i>
                    Cerrar Sesión
                </a>
            </li>
          <?php else: ?>
            <li><a href="#" id="loginBtn">Iniciar Sesión</a></li>
          <?php endif; ?>
        </ul>
      </nav>
    </div>
  </div>
</header>

<!-- Agregar el formulario de login -->
<div id="loginOverlay" class="overlay">
  <div class="login-form">
    <span class="close-btn">&times;</span>
    <h2>Iniciar Sesión</h2>
    <form action="controllers/procesar_login.php" method="POST">
      <div class="form-group">
        <input type="email" id="email" name="email" placeholder="Email" required>
      </div>
      <div class="form-group">
        <input type="password" id="password" name="password" placeholder="Contraseña" required>
      </div>
      <br>
      <p>¿No estás registrado? <a href="/register">Registrarse</a></p>
      <br>
      <button type="submit">Entrar</button>
        
    </form>
  </div>
</div>

<script>
  const loginBtn = document.getElementById('loginBtn');
  const loginOverlay = document.getElementById('loginOverlay');
  const closeBtn = document.querySelector('.close-btn');

  loginBtn.addEventListener('click', (e) => {
    e.preventDefault();
    loginOverlay.style.display = 'block';
  });

  closeBtn.addEventListener('click', () => {
    loginOverlay.style.display = 'none';
  });

  loginOverlay.addEventListener('click', (e) => {
    if (e.target === loginOverlay) {
      loginOverlay.style.display = 'none';
    }
  });
</script>
</body>
</html>