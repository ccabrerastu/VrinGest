<?php
class DashboardControlador
{
    public function Vista()
    {
        session_start();      
        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php");
            exit();
        }       
        if ($_SESSION['usuario'] === 'admin') {
            require 'views/DashboardA/Vista.php';
        } else {
            require 'views/DashboardU/Vista.php';
        }
    }
    public function index() {
    

    require 'views/DashboardUVista.php'; 
}

    public function index2() {
    

    require 'views/DashboardAVista.php'; 
}
}
