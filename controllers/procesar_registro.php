<?php
require_once '../models/BBDD.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Crear instancia de la base de datos
    $db = new BBDD();

    // Verificar si el usuario ya existe
    $resultado = $db->getEmail($email);

    if (count($resultado) > 0) {
        // Usuario ya existe
        echo "<script>
                alert('El correo electrónico ya está registrado');
                window.location.href = '../views/registro.php';
             </script>";
    } else {
        // El usuario no existe, proceder con el registro
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        
        // Insertar nuevo usuario
    
        $paramsInsert = array($email, $nombre, $passwordHash);
        
        if ($db->insertarUsuario($paramsInsert[0], $paramsInsert[1], $paramsInsert[2])) {   
            echo "<script>
                    alert('Registro exitoso');
                    window.location.href = '../index.php';
                 </script>";
        } else {
            echo "<script>
                    alert('Error al registrar el usuario');
                    window.location.href = '../views/registro.php';
                 </script>";
        }
    }
} else {
    // Si alguien intenta acceder directamente a este archivo
    header("Location: ../index.php");
    exit();
}
?>

