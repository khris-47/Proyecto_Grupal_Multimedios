
<?php

class CategoriaDoctor {
    public $id;
    public $doctor_id;
    public $categoria_id;

    public function __construct($id, $doctor_id, $categoria_id) {
        $this->id = $id;
        $this->doctor_id = $doctor_id;
        $this->categoria_id = $categoria_id;
    }
}

?>
