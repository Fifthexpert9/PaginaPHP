<?php
require_once '../models/BBDD.php';
require_once '../models/user.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Crear instancia de la base de datos
    $db = new BBDD();

    // Verificar si el usuario existe
    $resultado = $db->getEmail($email);

    if (count($resultado) > 0) {
        // El usuario existe, verificar contraseña
        $usuario = $db->getUserByEmail($email);
        $user = new user($usuario['nombre'], $usuario['email'], $usuario['contrasena']);
        
        if (password_verify($password, $user->getPassword())) {
            // Crear objeto Usuario y guardar en sesión
            
            $_SESSION['usuario'] = serialize($user);
            
            echo "<script>
                    alert('Inicio de sesión exitoso');
                    window.location.href = '/';
                 </script>";
        } else {
            echo "<script>
                    alert('Contraseña incorrecta');
                    window.location.href = '/login';
                 </script>";
        }
    } else {
        // Usuario no existe
        echo "<script>
                alert('El usuario no existe');
                window.location.href = '/login';
             </script>";
    }
} else {
    // Si alguien intenta acceder directamente a este archivo
    header("Location: /");
    exit();
}
?>

