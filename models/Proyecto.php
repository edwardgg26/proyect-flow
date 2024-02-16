<?php 

namespace Model;

class Proyecto extends ActiveRecord{

    protected static $tabla = "proyectos";
    protected static $columnasDB = ["id","nombre","descripcion","url","permitirlectura"];
    public $id;
    public $nombre;
    public $descripcion;
    public $url;
    public $permitirlectura;

    public function __construct($args = []){
        $this->id = $args["id"]??null;
        $this->nombre = $args["nombre"]??"";
        $this->descripcion = $args["descripcion"]??"";
        $this->url = $args["url"]??"";
        $this->permitirlectura = $args["permitirlectura"]??"";
    }

    public function setUrl(){
        $this->url = md5(uniqid());
    }

    public function set(){
        $this->url = md5(uniqid());
    }

    public function validarProyecto(){
        if(!$this->nombre){
            self::$alertas["danger"]["nombre"] = "Debes ingresar un nombre para el proyecto.";
        }

        if(!$this->descripcion){
            self::$alertas["danger"]["descripcion"] = "Debes ingresar una descripcion para el proyecto.";
        }else if(strlen($this->descripcion) > 500){
            self::$alertas["danger"]["descripcion"] = "La descripcion solo puede contener maximo 500 caracteres.";
        }

        if(!$this->permitirlectura){
            self::$alertas["danger"]["permitirlectura"] = "Debes seleccionar una opcion para el modo de lectura.";
        }

        return self::$alertas;
    }
}


?>