<?php 

namespace Controllers;
use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {
    public static function login(Router $router) {
        $alertas = [];
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarLogin();
            if(empty($alertas)) {
                $usuario = Usuario::where("email", $usuario->email);

                // if($usuario && $usuario->confirmado == 1){
                //     if(password_verify($_POST["password"], $usuario->password)) {
                //         session_start();
                //         $_SESSION["id"] = $usuario->id;
                //         $_SESSION["nombre"] = $usuario->nombre;
                //         $_SESSION["email"] = $usuario->email;
                //         $_SESSION["login"] = true;
                //         header("Location: /dashboard");
                //     }else{
                //         Usuario::setAlerta("danger","Contraseña incorrecta.");
                //     }
                // }
                if($usuario){
                    if(password_verify($_POST["password"], $usuario->password)) {
                        session_start();
                        $_SESSION["id"] = $usuario->id;
                        $_SESSION["nombre"] = $usuario->nombre;
                        $_SESSION["email"] = $usuario->email;
                        $_SESSION["login"] = true;
                        header("Location: /dashboard");
                    }else{
                        Usuario::setAlerta("danger","Contraseña incorrecta.");
                    }
                }else{
                    Usuario::setAlerta("danger","El usuario no existe o no está confirmado.");
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render("auth/login",[
            "titulo" => "Iniciar Sesión",
            "colores"=>"primary",
            "alertas" => $alertas
        ]);
    }

    public static function crear(Router $router) {

        $usuario = new Usuario;
        $alertas = [];

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarCreacion();

            if(empty($alertas)){
                $existeUsuario = Usuario::where("email", $usuario->email);

                if($existeUsuario){
                    Usuario::setAlerta("error","Ya hay un usuario registrado con ese email.");
                    $alertas = Usuario::getAlertas();
                }else{
                    $usuario->passwordHash();
                    $usuario->crearToken();
                    unset($usuario->passwordConfirm);
                    $resultado = $usuario->guardar();
                    // $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    // $email->enviarConfirmacion();

                    if($resultado){
                        header("Location: /mensaje-crear");
                    }
                }
            }
        }

        $router->render("auth/crear",[
            "titulo" => "Crear Cuenta",
            "colores"=>"secondary",
            "alertas" => $alertas,
            "usuario"=>$usuario
        ]);
    }

    public static function mensaje(Router $router) {
        $router->render("auth/mensaje",[
            "titulo" => "Confirma tu Cuenta",
            "colores"=>"fifth"
        ]);
    }

    public static function confirmar(Router $router) {

        $token = s($_GET["token"]);
        if(!$token) header("Location: /");

        $usuario = Usuario::where("token",$token);
        if(empty($usuario)){
            Usuario::setAlerta("danger","Token no valido.");
        }else{
            unset($usuario->passwordConfirm);
            $usuario->confirmado = 1;
            $usuario->token = null;
            $usuario->guardar();
            Usuario::setAlerta("success","Cuenta confirmada con exito.");
        }

        $alertas = Usuario::getAlertas();
        $router->render("auth/confirmacion",[
            "titulo" => "Confirmación de Cuenta",
            "alertas" => $alertas
        ]);
    }

    public static function olvide(Router $router) {
        $alertas = [];
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarOlvidePassword();
            if(empty($alertas)){
                $usuario = Usuario::where("email",$usuario->email);
                
                // if($usuario && $usuario->confirmado == 1){
                //     $usuario->crearToken();
                //     unset($usuario->passwordConfirm);
                //     $usuario->guardar();
                //     $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                //     $email->enviarReestablecimiento();

                //     Usuario::setAlerta("success","Hemos enviado a tu correo, las instrucciones para que puedas reestablecer la contraseña.");

                // }


                if($usuario){
                    $usuario->crearToken();
                    unset($usuario->passwordConfirm);
                    $usuario->guardar();
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarReestablecimiento();

                    Usuario::setAlerta("success","Hemos enviado a tu correo, las instrucciones para que puedas reestablecer la contraseña.");

                }else{
                    Usuario::setAlerta("danger","El usuario no existe o no esta confirmado.");
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render("auth/olvide",[
            "titulo" => "Olvide mi Contraseña",
            "alertas" => $alertas,
            "colores"=>"tertiary"
        ]);
    }

    public static function reestablecer(Router $router) {
        $token = s($_GET["token"]);
        $error = false;

        if(!$token) header("Location: /");

        $usuario = Usuario::where("token",$token);
        if(empty($usuario)){
            Usuario::setAlerta("danger","Token no valido.");
            $error = true;
        }

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarReestablecimiento();
            if(empty($alertas)){
                $usuario->token = null;
                $usuario->passwordHash();
                $resultado = $usuario->guardar();
                if($resultado){
                    header("Location: /");
                }
            }            
        }
        
        $alertas = Usuario::getAlertas();

        $router->render("auth/reestablecer",[
            "titulo" => "Reestablecimiento de Contraseña",
            "alertas" => $alertas,
            "error" => $error,
            "colores"=>"quaternary"
        ]);
    }

    public static function logout() {
        session_start();
        $_SESSION = [];
        header("Location: /");
    }
}

?>