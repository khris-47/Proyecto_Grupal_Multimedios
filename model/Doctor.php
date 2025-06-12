

<?php

class Doctor {
    public $id;
    public $nombre;
    public $correo;
    public $telefono;

    public function __construct($id, $nombre, $correo, $telefono) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->telefono = $telefono;
    }
}

?>
