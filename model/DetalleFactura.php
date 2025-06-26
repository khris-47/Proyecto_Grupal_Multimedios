<?php

class DetalleFactura {
    public $id;
    public $factura_id;
    public $medicamento_id;
    public $cantidad;
    public $precio_unitario
   
    public function __construct($id, $factura_id, $medicamento_id, $cantidad, $precio_unitario) {
        $this->id = $id;
        $this->factura_id = $factura_id;
        $this->medicamento_id = $medicamento_id;
       $this->cantidad = $cantidad;
        $this->precio_unitario = $precio_unitario;
    }
}

?>
