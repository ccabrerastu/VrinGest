<?php
require_once 'models/EquipoModel.php';

class EquipoControlador
{
    private $model;

    public function __construct()
    {
        $this->model = new EquipoModel();
    }

    public function index()
    {
        $equipos = $this->model->getAllEquipos();
        require 'views/gestionarEquipoVista.php';
    }

    public function create()
    {
        require 'views/agregarEquipoVista.php';
    }

    public function store()
    {
        $data = [
            'codigo_patrimonial' => $_POST['codigo_patrimonial'],
            'nombre' => $_POST['nombre'],
            'tipo' => $_POST['tipo'],
            'marca' => $_POST['marca'],
            'modelo' => $_POST['modelo'],
            'caracteristicas' => $_POST['caracteristicas'],
            'estado' => $_POST['estado'],
            'ubicacion' => $_POST['ubicacion'],
            'grupo_id' => $_POST['grupo_id'] ?? null,
            'responsable' => $_POST['responsable'] ?? null,
            'fecha_adquisicion' => $_POST['fecha_adquisicion']
        ];
        $this->model->insertEquipo($data);
        header("Location: index.php?c=Equipo&a=index");
    }

    public function edit()
    {
        $id = $_GET['id'];
        $equipo = $this->model->getEquipoById($id);
        require 'views/equipos/edit.php';
    }

    public function update()
    {
        $data = [
            'id' => $_POST['id'],
            'nombre' => $_POST['nombre'],
            'tipo' => $_POST['tipo'],
            'estado' => $_POST['estado'],
            'ubicacion' => $_POST['ubicacion'],
            'responsable' => $_POST['responsable'],
            'grupo_id' => $_POST['grupo_id'],
        ];
        $this->model->updateEquipo($data);
        header("Location: index.php?c=Equipo&a=index");
    }

    public function delete()
    {
        $id = $_GET['id'];
        $this->model->deleteEquipo($id);
        header("Location: index.php?c=Equipo&a=index");
    }

    public function historial()
    {
        $id = $_GET['id'];
        $historial = $this->model->getHistorialPrestamos($id);
        require 'views/equipos/historial.php';
    }
}