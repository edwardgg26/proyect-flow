<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\DashboardController;
use Controllers\LoginController;
use Controllers\TareaController;
use Controllers\UsuarioProyectoController;
use MVC\Router;
$router = new Router();

//Manejo de login y cuentas
$router->get("/", [LoginController::class,"login"]);
$router->post("/", [LoginController::class,"login"]);
$router->get("/crear-cuenta", [LoginController::class,"crear"]);
$router->post("/crear-cuenta", [LoginController::class,"crear"]);
$router->get("/mensaje-crear", [LoginController::class,"mensaje"]);
$router->get("/logout", [LoginController::class,"logout"]);
$router->get("/olvide-password", [LoginController::class,"olvide"]);
$router->post("/olvide-password", [LoginController::class,"olvide"]);
$router->get("/reestablecer-password", [LoginController::class,"reestablecer"]);
$router->post("/reestablecer-password", [LoginController::class,"reestablecer"]);
$router->get("/confirmar-cuenta", [LoginController::class,"confirmar"]);

//Proyectos
$router->get("/dashboard", [DashboardController::class,"index"]);
$router->get("/crear-proyecto", [DashboardController::class,"crear"]);
$router->post("/crear-proyecto", [DashboardController::class,"crear"]);
$router->get("/editar-proyecto", [DashboardController::class,"editar"]);
$router->post("/editar-proyecto", [DashboardController::class,"editar"]);
$router->get("/proyecto", [DashboardController::class,"proyecto"]);
$router->post("/proyecto", [DashboardController::class,"proyecto"]);

//Usuarios de un proyecto
$router->get("/editar-miembros", [UsuarioProyectoController::class,"index"]);
$router->post("/editar-miembros", [UsuarioProyectoController::class,"index"]);

//API Tareas
$router->get("/api/tareas",[TareaController::class,"index"]);
$router->post("/api/tarea",[TareaController::class,"crear"]);
$router->post("/api/tarea/actualizar",[TareaController::class,"actualizar"]);
$router->post("/api/tarea/eliminar",[TareaController::class,"eliminar"]);

//Perfil del usuario
$router->get("/perfil", [DashboardController::class,"perfil"]);
$router->post("/perfil", [DashboardController::class,"perfil"]);
$router->get("/cambiar-password", [DashboardController::class,"cambiarPassword"]);
$router->post("/cambiar-password", [DashboardController::class,"cambiarPassword"]);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();