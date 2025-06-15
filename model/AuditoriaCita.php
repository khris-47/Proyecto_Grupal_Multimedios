<?php

class AuditoriaCita {
    public $id;
    public $cita_id;
    public $accion;
    public $realizada_por;
    public $detalle;
    public $fecha;

    public function __construct($id, $cita_id, $accion, $realizada_por, $detalle, $fecha) {
        $this->id = $id;
        $this->cita_id = $cita_id;
        $this->accion = $accion;
        $this->realizada_por = $realizada_por;
        $this->detalle = $detalle;
        $this->fecha = $fecha;
    }
}

?>
