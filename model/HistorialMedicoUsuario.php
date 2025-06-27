<?php

class HistorialMedicoUsuario {
    public $id;
    public $paciente_id;
    public $cita_id;
    public $descripcion;
    public $observaciones;
    public $fecha;

    public function __construct($id, $paciente_id, $cita_id, $descripcion, $observaciones, $fecha) {
        $this->id = $id;
        $this->paciente_id = $paciente_id;
        $this->cita_id = $cita_id;
        $this->descripcion = $descripcion;
        $this->observaciones = $observaciones;
        $this->fecha = $fecha;
    }
}

?>


