<?php 

namespace Model;

class UsuarioProyecto extends ActiveRecord{
    protected static $tabla = "usuariosproyectos";
    protected static $columnasDB= ["id","id_usuario","id_proyecto","id_rol"];
    public $id;
    public $id_usuario;
    public $id_proyecto;
    public $id_rol;
    public function __construct($args = []){
        $this->id = $args["id"]??null;
        $this->id_usuario = $args["id_usuario"]??null;
        $this->id_rol = $args["id_rol"]??null;
        $this->id_proyecto = $args["id_proyecto"]??null;
    }

    public function setUsuario($id_usuario){
        $this->id_usuario = $id_usuario;
    }

    public function setRol($id_rol){
        $this->id_rol = $id_rol;
    }

    public function setProyecto($id_proyecto){
        $this->id_proyecto = $id_proyecto;
    }

    public function validarRol(){
        if(!$this->id_rol || $this->id_rol == "null"){
            self::$alertas["danger"]["id_rol"] = "Debes seleccionar un rol para el usuario";
        }else if ($this->id_rol == 1){
            self::$alertas["danger"]["id_rol"] = "Rol invalido";
        }

        return self::$alertas;
    }
}

?>