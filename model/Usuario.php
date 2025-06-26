
<?php 

class Usuario {
    public $id;
    public $cedula;
    public $nombre;
    public $email;
    public $password;
    public $id_rol;

    public function __construct($id, $cedula, $nombre, $email, $password, $id_rol) {
        $this->id = $id;
        $this->cedula = $cedula;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->password = $password;
        $this->id_rol = $id_rol;
    }
}

?>