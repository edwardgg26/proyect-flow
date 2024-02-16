<?php 

namespace Model;

class Rol extends ActiveRecord{

    protected static $tabla = "roles";
    protected static $columnasDB = ["id","rol"];
    public $id;
    public $rol;
    public $descripcion;

    public function __construct($args = []){
        $this->id = $args["id"]??null;
        $this->rol = $args["rol"]??"";
    }
}


?>