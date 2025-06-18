<?php

class Factura {
    public $id;
    public $cita_id;
    public $fecha;
    public $total;

    public function __construct($id, $cita_id, $fecha, $total) {
        $this->id = $id;
        $this->cita_id = $cita_id;
        $this->fecha = $fecha;
        $this->total = $total;
    }
}

?>
