<?php

class Factura {
    public $id;
    public $fecha;
    public $total;
    public $usuario_id;

    public function __construct($id, $fecha, $total, $usuario_id) {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->total = $total;
        $this->usuario_id = $usuario_id;

    }
}

?>
