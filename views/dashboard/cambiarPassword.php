<?php include_once("../views/templates/navHeader.php");?>

<div class="container p-5 align-items-center">
    <div class="row justify-content-center align-items-center">
        <h2 class="mb-4 text-center">
            <?php echo $titulo ?>
        </h2>
        
        <form class="col-12 col-md-6" method="POST">
            <?php include("../views/templates/alertas.php");?>

            <div class="form-floating is-invalid mt-3">
                <input type="password" class="form-control <?php if(isset($alertas["danger"]["passwordActual"])) echo "is-invalid"?>" name="passwordActual" id="passwordActual" placeholder="passwordActual">
                <label for="passwordActual">Contraseña Actual</label>
            </div>
            <?php if(isset($alertas["danger"]["passwordActual"])):?>
                <div class="invalid-feedback">
                    <?php echo $alertas["danger"]["passwordActual"]?>
                </div>
            <?php endif;?>

            <div class="form-floating is-invalid mt-3">
                <input type="password" class="form-control <?php if(isset($alertas["danger"]["passwordNuevo"])) echo "is-invalid"?>" name="passwordNuevo" id="passwordNuevo" placeholder="Password Actual">
                <label for="passwordNuevo">Contraseña Nueva</label>
            </div>
            <?php if(isset($alertas["danger"]["passwordNuevo"])):?>
                <div class="invalid-feedback">
                    <?php echo $alertas["danger"]["passwordNuevo"]?>
                </div>
            <?php endif;?>

            <div class="form-floating is-invalid mt-3">
                <input type="password" class="form-control <?php if(isset($alertas["danger"]["passwordConfirm"])) echo "is-invalid"?>" name="passwordConfirm" id="passwordConfirm" placeholder="passwordConfirm">
                <label for="passwordConfirm">Repetir Contraseña</label>
            </div>
            <?php if(isset($alertas["danger"]["passwordConfirm"])):?>
                <div class="invalid-feedback">
                    <?php echo $alertas["danger"]["passwordConfirm"]?>
                </div>
            <?php endif;?>
            <input type="submit" class="mt-3 btn btn-<?php echo $colores ?? "primary";?>" value="Guardar Cambios" />
        </form>
    </div>
</div>