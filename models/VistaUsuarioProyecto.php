<?php 

namespace Model;

class VistaUsuarioProyecto extends ActiveRecord{
    protected static $tabla = "vista_usuariosproyectos";
    protected static $columnasDB= ["id","nombreProyecto","descripcion","url","permitirlectura","id_usuario","nombreUsuario","email","id_rol","rol"];
    public $id;
    public $nombreProyecto;
    public $descripcion;
    public $url;
    public $permitirlectura;
    public $id_usuario;
    public $nombreUsuario;
    public $email;
    public $id_rol;
    public $rol;


    public function __construct($args = []){
        $this->id = $args["id"]??null;
        $this->nombreProyecto = $args["nombreProyecto"]??"";
        $this->descripcion = $args["descripcion"]??"";
        $this->url = $args["url"]??"";
        $this->permitirlectura = $args["permitirlectura"]??"";
        $this->id_usuario = $args["id_usuario"]??"";
        $this->nombreUsuario = $args["nombreUsuario"]??"";
        $this->email = $args["email"]??"";
        $this->id_rol = $args["id_rol"]??"";
        $this->rol = $args["rol"]??"";
    }
}

?>