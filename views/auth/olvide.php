<div class="container p-5 align-items-center">
    <?php include_once("../views/templates/logo.php");?>

    <div class="row justify-content-center align-items-center">  
        <h2 class="mb-4 text-center">Olvidé mi contraseña</h2>
        <form class="col-12 col-md-6" method="POST" action="/olvide-password">
            <?php include("../views/templates/alertas.php");?>
            <div class="form-floating is-invalid mt-3">
                <input type="email" name= "email" class="form-control <?php if(isset($alertas["danger"]["email"])) echo "is-invalid"?>" id="email" placeholder="name@example.com">
                <label for="email">Ingresa tu email para recuperar tu contraseña</label>
            </div>
            <?php if(isset($alertas["danger"]["email"])):?>
                <div class="invalid-feedback">
                    <?php echo $alertas["danger"]["email"]?>
                </div>
            <?php endif;?>
            <input type="submit" class="mt-3 btn btn-<?php echo $colores??"primary";?> mb-3" value="Enviar Instrucciones" />
        </form>
    </div>
    <div class="row justify-content-center align-items-center">
        <div class="col-12 col-md-6 d-flex justify-content-between">
            <a class="link-<?php echo $colores??"primary";?>" href="/">Volver al login</a>
            <a class="link-<?php echo $colores??"primary";?>" href="/crear-cuenta">Crear Cuenta</a>
        </div>
    </div>
</div>