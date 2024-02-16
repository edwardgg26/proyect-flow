<div class="container p-5 align-items-center">
    <?php include_once("../views/templates/logo.php");?>

    <div class="row justify-content-center align-items-center">  
        <h2 class="mb-4 text-center">Login</h2>
        <form class="col-12 col-md-6" method="POST" action="/">
            <?php include("../views/templates/alertas.php");?>

            <div class="form-floating is-invalid">
                <input type="email" name= "email" class="form-control <?php if(isset($alertas["danger"]["email"])) echo "is-invalid"?>" id="email" placeholder="name@example.com">
                <label for="email">Email</label>
            </div>
            <?php if(isset($alertas["danger"]["email"])):?>
                <div class="invalid-feedback">
                    <?php echo $alertas["danger"]["email"]?>
                </div>
            <?php endif;?>

            <div class="form-floating is-invalid mt-3">
                <input type="password" class="form-control <?php if(isset($alertas["danger"]["password"])) echo "is-invalid"?>" name="password" id="password" placeholder="Password">
                <label for="password">Contraseña</label>
            </div>
            <?php if(isset($alertas["danger"]["password"])):?>
                <div class="invalid-feedback">
                    <?php echo $alertas["danger"]["password"]?>
                </div>
            <?php endif;?>

            <input type="submit" class="mt-3 btn btn-<?php echo $colores??"primary";?> mb-3" value="Iniciar Sesión" />
        </form>
    </div>
    <div class="row justify-content-center align-items-center">
        <div class="col-12 col-md-6 d-flex justify-content-between">
            <a class="link-<?php echo $colores??"primary";?>" href="/crear-cuenta">Crear Cuenta</a>
            <a class="link-<?php echo $colores??"primary";?>" href="/olvide-password">Olvide mi contraseña</a>
        </div>
    </div>
</div>