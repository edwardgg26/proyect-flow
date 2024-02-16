<div class="container p-5 align-items-center">

    <?php include_once("../views/templates/logo.php");?>

    <div class="row justify-content-center align-items-center">  
        <h2 class="mb-4 text-center">Reestablecimiento de Contraseña</h2>
        <?php 
            include("../views/templates/alertas.php");
            if(!$error):
        ?>
            <form class="col-12 col-md-6" method="POST">
                <div class="form-floating is-invalid">
                    <input type="password" class="form-control <?php if(isset($alertas["danger"]["password"])) echo "is-invalid"?>" name="password" id="password" placeholder="Password">
                    <label for="password">Contraseña</label>
                </div>
                <?php if(isset($alertas["danger"]["password"])):?>
                    <div class="invalid-feedback">
                        <?php echo $alertas["danger"]["password"]?>
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
                <input type="submit" class="mt-3 btn btn-<?php echo $colores??"primary";?> mb-3" value="Reestablecer" />
            </form>
        <?php endif;?>
    </div>
    <div class="row justify-content-center align-items-center">
        <div class="col-12 col-md-6 d-flex justify-content-between">
            <a class="link-<?php echo $colores??"primary";?>" href="/">Volver al Login</a>
        </div>
    </div>
    
</div>