<?php

echo 'estoy en editar';

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$imagen = $_POST['imagen'];

require_once 'models/BBDD.php';

$db = new BBDD();

$db->editarProducto($id, $nombre, $imagen);

header("Location: /");