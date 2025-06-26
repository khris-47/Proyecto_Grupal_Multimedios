
<?php

class Cita {
    public $id;
    public $paciente_id;
    public $doctor_id;
    public $fecha;
    public $estado;

    public function __construct($id, $paciente_id, $doctor_id, $fecha, $estado = 'en espera') {
        $this->id = $id;
        $this->paciente_id = $paciente_id;
        $this->doctor_id = $doctor_id;
        $this->fecha = $fecha;
        $this->estado = $estado;
    }
}

?>
