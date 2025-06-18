
<?php

class Doctor {
    public $id;
    public $nombre;
    public $correo;
    public $telefono;
    public $email;
    public $password;
    public $id_rol;
    public $departamento_id;

    public function __construct($id, $nombre, $correo, $telefono, $email, $password, $id_rol, $departamento_id) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->telefono = $telefono;
        $this->email = $email;
        $this->password = $password;
        $this->id_rol = $id_rol;
        $this->departamento_id = $departamento_id;
    }
}

?>

