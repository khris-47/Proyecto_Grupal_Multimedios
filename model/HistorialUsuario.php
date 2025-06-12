<?php

class HistorialUsuario {
    public $id;
    public $cita_id;
    public $descripcion;
    public $observaciones;
    public $fecha;

    public function __construct($id, $cita_id, $descripcion, $observaciones, $fecha) {
        $this->id = $id;
        $this->cita_id = $cita_id;
        $this->descripcion = $descripcion;
        $this->observaciones = $observaciones;
        $this->fecha = $fecha;
    }
}

?>


