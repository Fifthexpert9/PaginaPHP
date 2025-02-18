<?php

require_once '../models/BBDD.php';
require_once '../models/producto.php';

$id = $_POST['id'];

$db = new BBDD();   

$db->eliminarProducto($id);

header("Location: /");