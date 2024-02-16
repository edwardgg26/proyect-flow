<?php include_once("../views/templates/navHeader.php");?>

<div class="container p-5 align-items-center">
    <div class="row justify-content-center align-items-center">
        <h2 class="mb-4 text-center">
            <?php echo $titulo ?>
        </h2>
        
        <form class="col-12 col-md-6" method="POST">
            <div>
                <a class="btn btn-dark" href="/cambiar-password">Cambiar Contraseña</a>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#eliminarCuentaModal">Borrar Cuenta</button>
            </div>  
            <?php include("../views/templates/alertas.php");?>

            <div class="form-floating is-invalid mt-3">
                <input type="text" value="<?php echo $usuario->nombre?>" name="nombre" class="form-control <?php if(isset($alertas["danger"]["nombre"])) echo "is-invalid"?>" id="nombre" placeholder="Username">
                <label for="nombre">Nombre</label>
            </div>
            <?php if(isset($alertas["danger"]["nombre"])):?>
                <div class="invalid-feedback">
                    <?php echo $alertas["danger"]["nombre"]?>
                </div>
            <?php endif;?>

            <div class="form-floating is-invalid mt-3">
                <input value="<?php echo $usuario->email?>" type="email" name= "email" class="form-control <?php if(isset($alertas["danger"]["email"])) echo "is-invalid"?>" id="email" placeholder="name@example.com">
                <label for="email">Email</label>
            </div>
            <?php if(isset($alertas["danger"]["email"])):?>
                <div class="invalid-feedback">
                    <?php echo $alertas["danger"]["email"]?>
                </div>
            <?php endif;?>
    
            <input type="hidden" name="tipo" value="editar">
            <input type="submit" class="mt-3 btn btn-<?php echo $colores ?? "primary";?>" value="Guardar Cambios" />
        </form>
    </div>
</div>

<div class="modal fade" id="eliminarCuentaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar Cuenta</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Seguro/a que deseas eliminar tu cuenta? Una vez eliminada no podras recuperar nada.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
        <form method="POST">
            <input type="hidden" name="tipo" value="eliminar">
            <!-- <input type="hidden" name="id" value="<?php echo $usuario->id?>"> -->
            <input value="Eliminar" type="submit" class="btn btn-danger"/>
        </form>
      </div>
    </div>
  </div>
</div>