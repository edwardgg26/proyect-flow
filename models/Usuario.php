<?php 

namespace Model;

class Usuario extends ActiveRecord{
    protected static $tabla = "usuarios";
    protected static $columnasDB= ["id","nombre","email","password","token","confirmado"];
    public $id;
    public $nombre;
    public $email;
    public $password;
    public $passwordActual;
    public $passwordNuevo;
    public $passwordConfirm;
    public $token;
    public $confirmado;
    public function __construct($args = []){
        $this->id = $args["id"]??null;
        $this->nombre = $args["nombre"]??"";
        $this->email = $args["email"]??"";
        $this->password = $args["password"]??"";
        $this->passwordActual = $args["passwordActual"]??"";
        $this->passwordNuevo = $args["passwordNuevo"]??"";
        $this->passwordConfirm = $args["passwordConfirm"]??"";
        $this->token = $args["token"]??"";
        $this->confirmado = $args["confirmado"]??0;
    }

    public function passwordHash(){
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken(){
        $this->token = md5(uniqid());
    }

    public function validarLogin(){
        $this->validarEmail();

        if(!$this->password){
            self::$alertas["danger"]["password"] = "Debe ingresar una contraseña.";
        }

        return self::$alertas;
    }

    public function validarCreacion(){
        if(!$this->nombre){
            self::$alertas["danger"]["nombre"] = "Debe ingresar un nombre."; 
        }
        
        $this->validarEmail();
        $this->validarPassword();

        return self::$alertas;
    }

    public function validarEdicion(){
        if(!$this->nombre){
            self::$alertas["danger"]["nombre"] = "Debe ingresar un nombre."; 
        }
        
        $this->validarEmail();
        // $this->validarPassword();

        return self::$alertas;
    }

    public function validarOlvidePassword(){
        $this->validarEmail();
        return self::$alertas;
    }

    public function validarReestablecimiento(){
        $this->validarPassword();
        return self::$alertas;
    }

    public function validarMiembro(){
        $this->validarEmail();

        return self::$alertas;
    }

    public function validarEmail(){
        if(!$this->email){
            self::$alertas["danger"]["email"] = "Debe ingresar un email."; 
        }else if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            self::$alertas["danger"]["email"] = "No es un tipo de email valido.";
        }
    }

    public function validarPassword(){
        if(!$this->password){
            self::$alertas["danger"]["password"] = "Debe ingresar una contraseña.";
        }else if (strlen($this->password) < 8 || 
                 strlen($this->password) > 16 || 
                 !preg_match('`[a-z]`',$this->password) || 
                 !preg_match('`[A-Z]`',$this->password) ||
                 !preg_match('`[0-9]`',$this->password)){
            self::$alertas["danger"]["password"] = "La contraseña debe contener minimo 8 caracteres y maximo 16, debe contener por lo menos una mayuscula, una minuscula y un numero.";
        }

        if(!$this->passwordConfirm){
            self::$alertas["danger"]["passwordConfirm"] = "Debe confirmar la contraseña.";
        }else if ($this->password !== $this->passwordConfirm){
            self::$alertas["danger"]["password"] = "La contraseña no son iguales.";
        }
    }

    public function validarCambioDePassword(){
        if(!$this->passwordActual){
            self::$alertas["danger"]["passwordActual"] = "Debes ingresar la contraseña actual";
        }

        if(!$this->passwordNuevo){
            self::$alertas["danger"]["passwordNuevo"] = "Debe ingresar una contraseña nueva.";
        }else if (strlen($this->passwordNuevo) < 8 || 
                 strlen($this->passwordNuevo) > 16 || 
                 !preg_match('`[a-z]`',$this->passwordNuevo) || 
                 !preg_match('`[A-Z]`',$this->passwordNuevo) ||
                 !preg_match('`[0-9]`',$this->passwordNuevo)){
            self::$alertas["danger"]["passwordNuevo"] = "La contraseña debe contener minimo 8 caracteres y maximo 16, debe contener por lo menos una mayuscula, una minuscula y un numero.";
        }

        if(!$this->passwordConfirm){
            self::$alertas["danger"]["passwordConfirm"] = "Debe confirmar la contraseña.";
        }else if ($this->passwordNuevo !== $this->passwordConfirm){
            self::$alertas["danger"]["password"] = "La contraseña no son iguales.";
        }

        return self::$alertas;
    }
}

?>