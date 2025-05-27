
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