<?php include_once("../views/templates/navHeader.php"); ?>

<div class="container-fluid p-5 align-items-center">
    <div class="row justify-content-center">
        <div>
            <h2 class="mb-3 text-center">
                <?php echo $titulo." | ".$usuariosproyecto[0]->nombreProyecto  ?>
            </h2>
        </div>
        <?php include("../views/templates/alertas.php");?>
        <?php if($usuarioPermitido == true && $rolUsuario < 3):?>
        <div class="col-lg-4">
            <form method="POST" name="agregar">
                <div class="form-floating is-invalid mt-3">
                    <input type="email" name= "email" class="form-control <?php if(isset($alertas["danger"]["email"])) echo "is-invalid"?>" id="email" placeholder="name@example.com">
                    <label for="email">Email</label>
                </div>
                <?php if(isset($alertas["danger"]["email"])):?>
                    <div class="invalid-feedback">
                        <?php echo $alertas["danger"]["email"]?>
                    </div>
                <?php endif;?>

                <select name="id_rol" class="mt-3 form-select <?php if(isset($alertas["danger"]["id_rol"])) echo "is-invalid"?>" id="id_rol" aria-describedby="id_rol">
                    <option selected value="null">Selecciona un rol para el usuario...</option>
                    <?php foreach($roles as $rol):?>
                        <?php if($rol->id > $rolUsuario):?>
                            <option value="<?php echo $rol->id;?>"><?php echo $rol->rol;?></option>
                        <?php endif;?>
                    <?php endforeach;?>
                </select>
                <?php if(isset($alertas["danger"]["id_rol"])):?>
                    <div class="invalid-feedback">
                        <?php echo $alertas["danger"]["id_rol"]?>
                    </div>
                <?php endif;?>
                <input type="hidden" name="tipo" value="agregar"/>
                <input type="submit" class="mt-3 btn btn-<?php echo $colores??"primary";?> mb-3" value="Agregar Usuario" />
            </form>
        </div>

        <div class="col-lg-8">
            <table class="mx-auto table">
                <thead>
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Email</th>
                        <th scope="col">Rol</th>
                        <th scope="col">Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($usuariosproyecto as $usuario):?>
                    <tr>
                        <td><?php echo $usuario->nombreUsuario?></td>
                        <td><?php echo $usuario->email?></td>
                        <td><?php echo $usuario->rol?></td>
                        <?php if($usuario->id_rol > $rolUsuario):?>
                            <td>
                                <form method="POST" name="eliminar"> 
                                    <input type="hidden" name="tipo" value="eliminar">
                                    <input type="hidden" name="id_usuario" value="<?php echo $usuario->id_usuario?>">
                                    <input type="submit" class="btn btn-danger" value="Eliminar"/>
                                </form>
                            </td>
                        <?php endif;?>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
        <?php endif;?>
    </div>
</div>