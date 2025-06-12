<?php

class AuditoriaCita {
    public $id;
    public $cita_id;
    public $accion;
    public $realizada_por;
    public $fecha;

    public function __construct($id, $cita_id, $accion, $realizada_por, $fecha) {
        $this->id = $id;
        $this->cita_id = $cita_id;
        $this->accion = $accion;
        $this->realizada_por = $realizada_por;
        $this->fecha = $fecha;
    }
}

?>
