<?php

$nombre = $_POST['nombre'];
$imagen = $_POST['imagen'];

require_once '../models/BBDD.php';

$db = new BBDD();

$db->insertarProducto($nombre, $imagen);

header("Location: /");