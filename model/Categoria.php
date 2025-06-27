<?php

class Categoria
{
    public $id;
    public $nombre;
    public $estado;

    public function __construct($id = null, $nombre = null, $estado = 'activo')
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->estado = $estado;
    }
}

?>