<?php

class Doctor
{
    public $id;
    public $nombre;
    public $telefono;
    public $email;
    public $password;
    public $id_rol;
    public $departamento_id;
    public $estado;
    public $categorias;

   public function __construct($id, $nombre, $telefono, $email, $password, $id_rol, $departamento_id, $estado, $categorias = [])
{
    $this->id = $id;
    $this->nombre = $nombre;
    $this->telefono = $telefono;
    $this->email = $email;
    $this->password = $password;
    $this->id_rol = $id_rol;
    $this->departamento_id = $departamento_id;
    $this->estado = $estado;
    $this->categorias = $categorias;
}


}

?>