<?php 
foreach($alertas as $key => $alerta):
    foreach($alerta as $keyAlert => $mensaje):
        if(is_int($keyAlert)):
?>
        <div class="alert alert-<?php echo $key?> alert-dismissible fade show" role="alert">
            <?php echo $mensaje;?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
<?php 
        endif;
    endforeach;
endforeach;
?>