<?php 

namespace Controllers;
use Model\Proyecto;
use Model\Tarea;
use Model\VistaUsuarioProyecto;

class TareaController{

    public static function index(){

        $id = s($_GET["id"]);
        if(!$id) header("Location: /dashboard");
        $proyecto = VistaUsuarioProyecto::belongsTo("url", $id);
        if(!$proyecto) header("Location: /dashboard");
        $tareas = Tarea::belongsTo("id_proyecto", $proyecto[0]->id);
        session_start();
        $usuarioPermitido = false;
        foreach($proyecto as $usuarioProyecto){
            if($usuarioProyecto->id_usuario == $_SESSION["id"]){
                $usuarioPermitido = true;
                break;
            }
        }

        $respuesta = [
            "tareas" => $tareas,
            "usuarioPermitido" => $usuarioPermitido
        ];

        echo json_encode($respuesta);
    }

    public static function crear(){
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $proyecto = VistaUsuarioProyecto::belongsTo("url", $_POST["id_proyecto"]);
            if(!$proyecto){
                $respuesta = [
                    "tipo" => "danger",
                    "mensaje" => "Hubo un error al crear la tarea."
                ];
                echo json_encode($respuesta);
                return;
            }
            
            //Validar que el usuario sea miembro del equipo
            session_start();
            $uEncontrado = false;
            foreach($proyecto as $usuarioProyecto){
                if($usuarioProyecto->id_usuario == $_SESSION["id"]){
                    $uEncontrado = true;
                    break;
                }
            }

            if(!$uEncontrado){
                $respuesta = [
                    "tipo" => "danger",
                    "mensaje" => "No eres miembro de este proyecto."
                ];
                echo json_encode($respuesta);
                return;
            }

            $tarea = new Tarea($_POST);
            $tarea->setIdProyecto($proyecto[0]->id);
            $resultado = $tarea->guardar();
            $respuesta = [
                "tipo" => "success",
                "mensaje" => "Tarea creada con exito.",
                "id" => $resultado["id"],
                "id_proyecto" => $proyecto[0]->id
            ];
            echo json_encode($respuesta);
        }
    } 

    public static function actualizar(){
        
        if($_SERVER["REQUEST_METHOD"] === "POST"){

            $proyecto = VistaUsuarioProyecto::belongsTo("url", $_POST["id_proyecto"]);
            if(!$proyecto){
                $respuesta = [
                    "tipo" => "danger",
                    "mensaje" => "Hubo un error al actualizar la tarea."
                ];
                echo json_encode($respuesta);
                return;
            }

            //Validar que el usuario sea miembro del equipo
            session_start();
            $uEncontrado = false;
            foreach($proyecto as $usuarioProyecto){
                if($usuarioProyecto->id_usuario == $_SESSION["id"]){
                    $uEncontrado = true;
                    break;
                }
            }

            if(!$uEncontrado){
                $respuesta = [
                    "tipo" => "danger",
                    "mensaje" => "No eres miembro de este proyecto."
                ];
                echo json_encode($respuesta);
                return;
            }

            $tarea = new Tarea($_POST);
            $tarea->setIdProyecto($proyecto[0]->id);
            $resultado = $tarea->guardar();
            if($resultado){
                $respuesta = [
                    "tipo" => "success",
                    "id_proyecto" => $proyecto[0]->id,
                    "id" => $tarea->id,
                    "mensaje" => "Tarea actualizada con exito."
                ];
                echo json_encode($respuesta);
            }

        }
    } 

    public static function eliminar(){
        
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $proyecto = VistaUsuarioProyecto::belongsTo("url", $_POST["id_proyecto"]);
            if(!$proyecto){
                $respuesta = [
                    "tipo" => "danger",
                    "mensaje" => "Hubo un error al actualizar la tarea."
                ];
                echo json_encode($respuesta);
                return;
            }

            //Validar que el usuario sea miembro del equipo
            session_start();
            $uEncontrado = false;
            foreach($proyecto as $usuarioProyecto){
                if($usuarioProyecto->id_usuario == $_SESSION["id"]){
                    $uEncontrado = true;
                    break;
                }
            }

            if(!$uEncontrado){
                $respuesta = [
                    "tipo" => "danger",
                    "mensaje" => "No eres miembro de este proyecto."
                ];
                echo json_encode($respuesta);
                return;
            }

            $tarea = new Tarea($_POST);
            $resultado = $tarea->eliminar();
            if($resultado){
                $respuesta = [
                    "resultado"=> $resultado,
                    "tipo" => "success",
                    "mensaje"=>"Tarea eliminada correctamente"
                ];
                echo json_encode($respuesta);
            }
        }
    } 
}

?>