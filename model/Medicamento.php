<?php

class Medicamento {
    public $id;
    public $nombre;
    public $descripcion;
    public $cantidad;
    public $precio_unitario

    public function __construct($id, $nombre, $descripcion, $cantidad, $precio_unitario) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->cantidad = $cantidad;
        $this->precio_unitario = $precio_unitario;
        
    }

}

?>
