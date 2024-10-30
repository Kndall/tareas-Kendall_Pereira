<?php

echo "hola mundo";

// Obtenemos en una variable el método de solicitud utilizado; puede ser GET, PUT, DELETE, POST, etc.
$method = $_SERVER['REQUEST_METHOD'];
// $_SERVER contiene información del servidor, como el método de solicitud actual
echo $method;

// Verificamos si la variable PATH_INFO está definida y obtenemos la ruta de la solicitud, eliminando "/" al inicio y final.
// Si no está definida, incluimos una página de error.
$path = isset($_SERVER['PATH_INFO']) ? trim($_SERVER['PATH_INFO'], '/') : include_once "error/response.html";

// Mostramos el valor de $path, que representa el archivo o ruta solicitada
echo $path;

// Dividimos la ruta en segmentos usando "/" para obtener el endpoint y posibles parámetros
$segments = explode('/', $path);

// Capturamos la cadena de consulta después del "?" en la URL (ejemplo: "id=123&nombre=juan")
$queryString = $_SERVER['QUERY_STRING'];

// Convertimos la cadena de consulta en un arreglo asociativo
parse_str($queryString, $queryParams);

// Extraemos el parámetro "cedula" de la cadena de consulta si está definido
$cedula = isset($queryParams['cedula']) ? $queryParams['cedula'] : null;

// Si el valor de $path es "usuarios", procesamos la solicitud
if ($path == "usuarios") {
    switch ($method) {
        case 'GET':
            if ($cedula != "") {
                echo json_encode(['Alert' => 'Hola: ' . $cedula]);
            } else {
                echo json_encode(['Alert' => 'a. Lista de todos los usuarios']);
            }
            break;
        default:
            Response::json(['error' => 'Método no permitido'], 405);
    }
} else {
    // Incluimos una página de error si la ruta no es "usuarios"
    include "error/response.html";
}

?>
