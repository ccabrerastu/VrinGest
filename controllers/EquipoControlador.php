<?php
require_once 'model/EquipoModel.php';

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
        $nuevoCodigoPatrimonial = $this->model->generarNuevoCodigoPatrimonial();
        $tiposEquipo = $this->model->getTiposEquipo();
        $estados = $this->model->getEstados();
        $grupos = $this->model->getGrupos();
        $nuevoCodigoBarras = $this->model->generarNuevoCodigoBarras();

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
public function detalle() {
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        echo '<p class="text-red-600 font-semibold">ID inválido.</p>';
        return;
    }

    $id = intval($_GET['id']);
    $equipo = $this->model->getEquipoById($id);

    if (!$equipo) {
        echo '<p class="text-red-600 font-semibold">Equipo no encontrado.</p>';
        return;
    }
    // Mostrar características
    $caracteristicas = $this->model->getCaracteristicasByEquipo($id);

    if (!empty($caracteristicas)) {
        echo '<h4 class="text-lg font-semibold mb-4 border-b pb-2">Características</h4>';
        echo '<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">';
        foreach ($caracteristicas as $carac) {
            echo '<div class="bg-gray-100 p-4 rounded shadow">';
            echo '<p class="font-bold text-indigo-700 mb-1">' . htmlspecialchars($carac['nombre']) . '</p>';
            echo '<p class="text-gray-800">' . htmlspecialchars($carac['valor']) . '</p>';
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo '<p class="text-gray-600 italic">No hay características registradas.</p>';
    }
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
    public function formularioCrear() {
    $nuevoCodigoPatrimonial = $this->model->generarNuevoCodigoPatrimonial();
    require 'views/gestionarEquipoVista.php';
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