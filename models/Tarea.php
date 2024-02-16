<?php 

namespace Model;

class Tarea extends ActiveRecord{

    protected static $tabla = "tareas";
    protected static $columnasDB = ["id","tarea","estado","fechaInicio","fechaFin", "id_proyecto"];

    public $id;
    public $tarea;
    public $estado;
    public $fechaInicio;
    public $fechaFin;
    public $id_proyecto;

    public function __construct($args = []){
        $this->id = $args["id"]??null;
        $this->tarea = $args["tarea"]??"";
        $this->estado = $args["estado"]??0;
        $this->fechaInicio = $args["fechaInicio"]??"";
        $this->fechaFin = $args["fechaFin"]??"";
        $this->id_proyecto = $args["id_proyecto"]??"";
    }

    public function setIdProyecto($id_proyecto){
        $this->id_proyecto = $id_proyecto;
    }
}
?>