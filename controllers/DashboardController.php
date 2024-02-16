<?php 
namespace Controllers;
use Model\Proyecto;
use Model\Usuario;
use Model\UsuarioProyecto;
use Model\VistaUsuarioProyecto;
use MVC\Router;

class DashboardController{
    public static function index(Router $router){
        session_start();
        isAuth();
        $proyectos = VistaUsuarioProyecto::belongsTo("id_usuario",$_SESSION["id"]);

        $router->render("dashboard/index",[
            "titulo"=> "Mi Dashboard",
            "colores"=>"quaternary",
            "nombre"=> $_SESSION["nombre"],
            "proyectos" => $proyectos
        ]);
    }

    public static function crear(Router $router){
        session_start();
        isAuth();
        $alertas = [];
        $proyecto = new Proyecto;

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $proyecto->sincronizar($_POST);
            $alertas = $proyecto->validarProyecto();

            if(empty($alertas)){
                $proyecto->setUrl();
                $resultado = $proyecto->guardar();
                if($resultado){
                    $usuarioproyecto = new UsuarioProyecto;
                    $usuarioproyecto->setUsuario($_SESSION["id"]);
                    $usuarioproyecto->setRol(1);
                    $usuarioproyecto->setProyecto($resultado["id"]);
                    $resultadoLinea = $usuarioproyecto->guardar();
                    if($resultadoLinea) header("Location: /proyecto?id='".$proyecto->url."'");
                }
            }
        }

        $router->render("dashboard/crear",[
            "titulo"=> "Crear Proyecto",
            "alertas"=>$alertas,
            "nombre"=> $_SESSION["nombre"],
            "proyecto"=>$proyecto
        ]);
    }

    public static function editar(Router $router){
        session_start();
        isAuth();
        $alertas = [];
        $id = s($_GET["id"]);
        if(!$id) header("Location: /dashboard");
        $usuariosproyecto = VistaUsuarioProyecto::belongsTo("url",$id);
        $usuarioPermitido = false;
        $proyecto = Proyecto::where("url",$id);
        $rolUsuario = 3;
        
        if($usuariosproyecto && $proyecto){
            foreach($usuariosproyecto as $usuarioProyecto){
                if($usuarioProyecto->id_usuario == $_SESSION["id"]){
                    $usuarioPermitido = true;
                    $rolUsuario = intval($usuarioProyecto->id_rol);
                    break;
                }
            }
            if($usuarioPermitido === false && $usuariosproyecto[0]->permitirlectura != "si") header("Location: /dashboard");
            if($usuarioPermitido != true || $usuarioPermitido == true && $rolUsuario == 3){
                Proyecto::setAlerta("danger","No tienes permisos para editar el proyecto.");
            }
        }

        if($_SERVER["REQUEST_METHOD"] === "POST" && $usuarioPermitido == true && $rolUsuario < 3){
            $proyecto->sincronizar($_POST);
            $alertas = $proyecto->validarProyecto();

            if(empty($alertas)){
                $resultado = $proyecto->guardar();
                if($resultado) header("Location: /proyecto?id=".$proyecto->url);
            }
        }

        $alertas = Proyecto::getAlertas();

        $router->render("dashboard/editar",[
            "titulo"=> "Editar Proyecto",
            "alertas"=>$alertas,
            "nombre"=> $_SESSION["nombre"],
            "proyecto"=>$proyecto,
            "usuarioPermitido" => $usuarioPermitido,
            "rolUsuario" => $rolUsuario
        ]);
    }

    public static function proyecto(Router $router){
        session_start();
        isAuth();
        $id = s($_GET["id"]);
        if(!$id) header("Location: /dashboard");

        $proyecto = VistaUsuarioProyecto::belongsTo("url",$id);
        $usuarioPermitido = false;
        $rolUsuario = 3;
        foreach($proyecto as $usuarioProyecto){
            if($usuarioProyecto->id_usuario == $_SESSION["id"]){
                $usuarioPermitido = true;
                $rolUsuario = intval($usuarioProyecto->id_rol);
                break;
            }
        }

        if($usuarioPermitido === false && $proyecto[0]->permitirlectura != "si") header("Location: /dashboard");

        if($_SERVER["REQUEST_METHOD"] === "POST" && $usuarioPermitido !== false && $rolUsuario === 1){
            if(isset($_POST["tipo"]) && $_POST["tipo"] == "eliminar" && $_POST["id"] == $proyecto[0]->id){
                $proyecto = Proyecto::where("url",$id);
                if($proyecto){
                    $resultado = $proyecto->eliminar();
                    if($resultado) header("Location: /dashboard");
                }
            }
        }

        $router->render("dashboard/proyecto",[
            "titulo"=> $proyecto[0]->nombreProyecto,
            "colores"=>"fifth",
            "nombre"=> $_SESSION["nombre"],
            "proyecto"=>$proyecto,
            "usuarioPermitido" => $usuarioPermitido,
            "rolUsuario" => $rolUsuario
        ]);
    }

    public static function perfil(Router $router){
        session_start();
        isAuth();
        $alertas = [];
        $usuario = Usuario::find($_SESSION["id"]);

        if($_SERVER["REQUEST_METHOD"] === "POST"){

            //Editar informacion del usuario
            if(isset($_POST["tipo"]) && $_POST["tipo"] === "editar"){
                $usuario->sincronizar($_POST);
                $alertas = $usuario->validarEdicion();
                if(empty($alertas)){
                    //Validar Correo
                    $existeUsuario = Usuario::where("email", $usuario->email);
                    if($existeUsuario && $_SESSION["email"] !== $existeUsuario->email){
                        Usuario::setAlerta("danger","Ya hay un usuario registrado con ese email.");
                    }else{
                        $resultado = $usuario->guardar();
                        if($resultado){
                            $_SESSION["nombre"] = $usuario->nombre;
                            $_SESSION["email"] = $usuario->email;
                            Usuario::setAlerta("success","Perfil actualizado con exito.");
                        }
                    }
                }
            }

            //Eliminar Usuario
            if(isset($_POST["tipo"]) && $_POST["tipo"] === "eliminar"){
                $usuario = Usuario::find($_SESSION["id"]);
                $error = false;

                //Encontrar los proyectos asociados
                $usuarioproyectos = UsuarioProyecto::belongsTo("id_usuario",$_SESSION["id"]);
                if($usuario && $usuarioproyectos){
                    foreach($usuarioproyectos as $registroUsuario){
                        //Quitar miembro del usuario de un proyecto asociado en el que no sea lider
                        if($registroUsuario->id_rol != 1){
                            $resultadoEliminar = $registroUsuario->eliminar();
                            if(!$resultadoEliminar) $error = true;
                        }

                        //Eliminar los proyectos en los que es lider
                        if($error == false && $registroUsuario->id_rol == 1){
                            $proyecto = Proyecto::find($registroUsuario->id_proyecto);
                            if($proyecto){
                                $resultadoEliminarProyecto = $proyecto->eliminar();
                                $resultadoEliminarRegistro = $registroUsuario->eliminar();
                                if(!$resultadoEliminarProyecto && $resultadoEliminarRegistro) $error = true;
                            }else{
                                $error = true;
                            }
                        }

                        if($error == true){
                            Usuario::setAlerta("danger", "Error al eliminar el usuario.");
                            break;
                        }
                    }
                    //Eliminar el usuario y redirigir
                    $resultado = $usuario->eliminar();
                    if($resultado){
                        $_SESSION = [];
                        header("Location: /");  
                    }else{
                        Usuario::setAlerta("danger", "Error al eliminar el usuario.");
                    }
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render("dashboard/perfil",[
            "titulo"=> "Mi Perfil",
            "colores"=>"tertiary",
            "nombre"=> $_SESSION["nombre"],
            "alertas" => $alertas,
            "usuario" => $usuario
        ]);
    }

    public static function cambiarPassword(Router $router){
        session_start();
        isAuth();
        $alertas = [];

        //Cambiar Password
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $usuario = Usuario::find($_SESSION["id"]);
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarCambioDePassword();

            if(empty($alertas)){

                //Validar contraseña actual
                $resultado = password_verify($usuario->passwordActual, $usuario->password);
                if($resultado){
                    $usuario->password = $usuario->passwordNuevo;
                    $usuario->passwordHash();
                    unset($usuario->passwordActual);
                    unset($usuario->passwordNuevo);
                    $resultadoGuardar = $usuario->guardar();
                    if($resultadoGuardar) Usuario::setAlerta("success","Contraseña actualizada con exito.");
                }else{
                    Usuario::setAlerta("danger","La contraseña actual no es correcta.");
                }
            }
        }

        $alertas = Usuario::getAlertas(); 

        $router->render("dashboard/cambiarPassword",[
            "titulo"=> "Cambiar Contraseña",
            "colores"=>"tertiary",
            "nombre"=> $_SESSION["nombre"],
            "alertas" => $alertas
        ]);
    }
}
?>