<?php include_once("../views/templates/navHeader.php");?>

<div class="mx-3 my-2 mx-md-5 my-md-4">
    <h2 class="mb-3"><?php echo $titulo?> 
        <?php if($usuarioPermitido === true && $rolUsuario < 3):?> 
            <a href="/editar-proyecto?id=<?php echo $proyecto[0]->url;?>" class="btn btn-dark btn-sm">Editar</a> 
            <a href="/editar-miembros?id=<?php echo $proyecto[0]->url;?>" class="btn btn-quaternary btn-sm">Miembros</a>
            <?php if($rolUsuario === 1):?> 
                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#eliminarProyectoModal">Eliminar Proyecto</button>
            <?php endif;?> 
        <?php endif;?> 
    </h2>
    <?php if($usuarioPermitido === true):?> 
    <button type="button" class="btn btn-<?php echo $colores ?? "primary"?>" data-bs-toggle="modal" data-bs-whatever="Agregar Tarea" data-bs-target="#modalTarea">Agregar Tarea</button>
    <?php endif;?> 

    <div id="contenedorAlertasVentana" class="my-3">
    </div>

    <div class="container-fluid p-2">
        <div class="row g-3">
            <ul id="listado-tareas" class="col-lg-8 col-xl-10 list-group">
            </ul>

            <div class="order-first order-lg-last col-lg-4 col-xl-2" id="filtros">
                <h5>Filtrar Tareas</h5>
                <div class="form-check">
                    <input class="form-check-input" value="" type="radio" name="filtroTareas" id="todasFiltro" checked>
                    <label class="form-check-label" for="todasFiltro">Todas</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" value="0" type="radio" name="filtroTareas" id="pendientes">
                    <label class="form-check-label" for="pendientes">Pendientes</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" value="1" type="radio" name="filtroTareas" id="completas">
                    <label class="form-check-label" for="completas">Completadas</label>
                </div>
            </div>
        </div>
    </div>
    
</div>
<?php if($usuarioPermitido === true){
    include_once("modal_tarea.php");
    if($rolUsuario === 1){
        include_once("modal_eliminar_proyecto.php");
    }
}?> 

<?php $script = "<script src='/build/js/tareas.js'></script>";?>