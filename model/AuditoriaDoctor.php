<?php

class AuditoriaDoctor
{
    public $id;
    public $doctor_id;
    public $accion;
    public $realizada_por;
    public $detalle;
    public $fecha;

    public function __construct($id, $doctor_id, $accion, $realizada_por, $detalle, $fecha)
    {
        $this->id = $id;
        $this->doctor_id = $doctor_id;
        $this->accion = $accion;
        $this->realizada_por = $realizada_por;
        $this->detalle = $detalle;
        $this->fecha = $fecha;
    }
}

?>
