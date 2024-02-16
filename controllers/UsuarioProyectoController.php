<?php 

namespace Controllers;
use MVC\Router;
use Model\VistaUsuarioProyecto;
use Model\Rol;
use Model\Usuario;
use Model\UsuarioProyecto;

//Controlador que se encarga de la administracion de miembros en un proyecto
class UsuarioProyectoController {

    public static function index(Router $router) {
        session_start();
        isAuth();
        $alertas = [];
        $id = s($_GET["id"]);
        if(!$id) header("Location: /dashboard");

        //Obtener usuarios del proyecto y roles
        $usuariosproyecto = VistaUsuarioProyecto::belongsTo("url",$id);
        $usuarioPermitido = false;
        $rolUsuario = 3;
        $roles = Rol::all();
        $usuario = new Usuario;
        $newusuarioproyecto = new UsuarioProyecto;

        if($usuariosproyecto && $roles){
            foreach($usuariosproyecto as $usuarioProyecto){
                if($usuarioProyecto->id_usuario == $_SESSION["id"]){
                    $usuarioPermitido = true;
                    $rolUsuario = intval($usuarioProyecto->id_rol);
                    break;
                }
            }

            if($usuarioPermitido === false && $usuariosproyecto[0]->permitirlectura != "si") header("Location: /dashboard");
            if($usuarioPermitido != true || $usuarioPermitido == true && $rolUsuario == 3){
                UsuarioProyecto::setAlerta("danger","No tienes permisos para editar el proyecto.");
            }
        }

        if($_SERVER["REQUEST_METHOD"] === "POST" && $usuarioPermitido !== false && $rolUsuario < 3){
            if(isset($_POST["tipo"]) && $_POST["tipo"] == "agregar" && $_POST["id_rol"] > $rolUsuario){
                $usuario->sincronizar($_POST);
                $newusuarioproyecto->sincronizar($_POST);

                $alertas = $usuario->validarMiembro();
                $alertas = $newusuarioproyecto->validarRol();

                if(empty($alertas)){

                    //Validar que haya un usuario con el email proporcionado
                    $usuario = Usuario::where("email", $usuario->email);

                    // if($usuario && $usuario->confirmado == 1){
                    if($usuario){

                        //Validar que el usuario no se encuentre ya en el proyecto
                        $yaEnProyecto = false;
                        foreach($usuariosproyecto as $usuarioLista){
                            if($usuarioLista->email == $usuario->email){
                                Usuario::setAlerta("danger","El usuario ya es miembro de este proyecto.");
                                $yaEnProyecto = true;
                                break;
                            }
                        }

                        //Ingresarlo
                        if(!$yaEnProyecto){
                            $newusuarioproyecto->setProyecto($usuariosproyecto[0]->id);
                            $newusuarioproyecto->setUsuario($usuario->id);
                            $resultado = $newusuarioproyecto->guardar();

                            if($resultado) header("Location: /editar-miembros?id=${id}");
                        }

                    }else{
                        Usuario::setAlerta("danger","El usuario no existe o no esta confirmado.");
                    }
                }
            }

            if(isset($_POST["tipo"]) && $_POST["tipo"] == "eliminar"){

                $encontrado = false;
                $url = null;

                //Validar el usuario que se va a borrar del proyecto y que no sea el creador
                foreach($usuariosproyecto as $registroUsuario){
                    if($rolUsuario === 1 && $registroUsuario->id_usuario == $_POST["id_usuario"] && $registroUsuario->id_rol != 1){
                        $encontrado = true;
                        $url = $registroUsuario->url;
                        break;
                    }

                    if($rolUsuario === 2 && $registroUsuario->id_usuario == $_POST["id_usuario"] && $registroUsuario->id_rol > 2){
                        $encontrado = true;
                        $url = $registroUsuario->url;
                        break;
                    }
                }

                if($encontrado){
                    //Consulto el registro a eliminar
                    $query = "SELECT * FROM usuariosproyectos WHERE id_usuario = ".$_POST["id_usuario"]." AND id_proyecto = ".$usuariosproyecto[0]->id.";";
                    $newusuarioproyecto = UsuarioProyecto::consultarSQL($query);
                    if($newusuarioproyecto){
                        $resultado = $newusuarioproyecto[0]->eliminar();
                        if($resultado) header("Location: /editar-miembros?id=${url}");
                    }
                }else{
                    UsuarioProyecto::setAlerta("danger","Usuario a eliminar no valido");
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $alertas = UsuarioProyecto::getAlertas();

        $router->render("dashboard/miembros",[
            "titulo"=> "Miembros del Proyecto",
            "alertas"=>$alertas,
            "colores" => "quaternary",
            "nombre"=> $_SESSION["nombre"],
            "usuariosproyecto"=>$usuariosproyecto,
            "roles" => $roles,
            "usuarioPermitido" => $usuarioPermitido,
            "rolUsuario" => $rolUsuario
        ]);
    }
}

?>