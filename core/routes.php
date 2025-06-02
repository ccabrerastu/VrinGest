<?php

function cargarControlador($controlador) {
    $controlador = $controlador . "Controlador";
    $archivo = "controllers/" . $controlador . ".php";

   if (file_exists($archivo)) {
        require_once $archivo;
       if (class_exists($controlador)) {
            return new $controlador();
        } else {
           die("La clase '$controlador' no existe.");
        }
     } else {
        die("El archivo del controlador '$archivo' no fue encontrado.");
     }
}

function cargarAccion($controlador, $accion, $id = null) {
    if (method_exists($controlador, $accion)) {
        if ($id !== null) {
            $controlador->$accion($id);
        } else {
            $controlador->$accion();
        }
    } else {
        die("La acción '$accion' no está definida en el controlador.");
    }
}
