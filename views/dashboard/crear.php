<?php include_once("../views/templates/navHeader.php");?>

<div class="container p-5 align-items-center">
    <div class="row justify-content-center align-items-center">  
        <h2 class="mb-4 text-center"><?php echo $titulo?></h2>
        <form class="col-12 col-md-6" method="POST" action="/crear-proyecto">
            <?php include("../views/templates/alertas.php");?>

            <?php include_once("formulario_proyecto.php");?>
            
            <input type="submit" class="mt-3 btn btn-<?php echo $colores??"primary";?> mb-3" value="Crear Proyecto" />
        </form>
    </div>
</div>