<?php include_once("../views/templates/navHeader.php"); ?>

<div class="container p-5 align-items-center">
    <div class="row justify-content-center align-items-center">
        <h2 class="mb-4 text-center">
            <?php echo $titulo ?>
        </h2>
        <form class="col-12 col-md-6" method="POST">
            <?php include("../views/templates/alertas.php"); ?>

            <?php if($usuarioPermitido === true && $rolUsuario < 3):
                include_once("formulario_proyecto.php");?> 
                <input type="submit" class="mt-3 btn btn-<?php echo $colores ?? "primary";?>" value="Guardar Cambios" />
            <?php endif;?>
        </form>
    </div>
</div>