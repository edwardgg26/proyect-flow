<?php include_once("../views/templates/navHeader.php"); ?>

<div class="mx-3 my-2 mx-md-5 my-md-4">
    <h2 class="mb-3">Mis Proyectos</h2>
    <a href="/crear-proyecto" class="mb-4 btn btn-<?php echo $colores ?? "primary"; ?>">Nuevo Proyecto</a>

    <div class="container-fluid p-0">
        <div class="row row-cols-2 row-cols-lg-3 g-3">
            <?php foreach ($proyectos as $proyecto): ?> 
                <?php if ($proyecto->id_rol == 1): ?> 
                    <div class="col text-center">
                        <a href='/proyecto?id=<?php echo $proyecto->url?>' class="text-decoration-none">
                            <p class="m-0 fw-bold py-5 bg-<?php echo $colores ?? "primary";?> text-light">
                                <?php echo $proyecto->nombreProyecto ?>
                            </p>
                        </a>
                    </div>
                <?php endif;?> 
            <?php endforeach;?> 

            
            <?php 
            $imprimirSubtitulo = true;
            
            foreach ($proyectos as $proyecto): ?> 

                <?php if ($proyecto->id_rol != 1): ?> 
                    <?php if ($imprimirSubtitulo == true): ?>
                    <h2 class="w-100">Proyectos a los que pertenezco</h2>
                    <?php 
                    $imprimirSubtitulo = false;
                    endif; ?>

                    <div class="col text-center">
                        <a href='/proyecto?id=<?php echo $proyecto->url?>' class="text-decoration-none">
                            <p class="m-0 fw-bold py-5 bg-<?php echo $colores ?? "primary";?> text-light">
                                <?php echo $proyecto->nombreProyecto ?>
                            </p>
                        </a>
                    </div>
                <?php endif;?> 
            <?php endforeach;?> 
        </div>
    </div>
</div>
