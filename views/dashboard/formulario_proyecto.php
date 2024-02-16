<div class="form-floating is-invalid">
    <input value="<?php echo $proyecto->nombre?>" type="text" name="nombre" class="form-control <?php if (isset($alertas["danger"]["nombre"])) echo "is-invalid" ?>" id="nombre" placeholder="Username">
    <label for="nombre">Nombre del proyecto</label>
</div>
<?php if (isset($alertas["danger"]["nombre"])): ?>
    <div class="invalid-feedback">
        <?php echo $alertas["danger"]["nombre"] ?>
    </div>
<?php endif; ?>

<div class="form-floating is-invalid mt-3">
  <textarea name="descripcion" class="form-control <?php if (isset($alertas["danger"]["nombre"])) echo "is-invalid" ?>" placeholder="Leave a comment here" id="descripcion" style="height: 100px"><?php echo $proyecto->descripcion?></textarea>
  <label for="descripcion">Descripción</label>
</div>
<?php if (isset($alertas["danger"]["descripcion"])): ?>
    <div class="invalid-feedback">
        <?php echo $alertas["danger"]["descripcion"] ?>
    </div>
<?php endif; ?>

<p class="mt-3">Permitir que otras personas vean tu proyecto con el enlace.</p>
<div class="form-check">
  <input class="form-check-input <?php if (isset($alertas["danger"]["permitirlectura"])) echo "is-invalid" ?>" value="si" type="radio" name="permitirlectura" id="permitirlectura1" <?php echo ($proyecto->permitirlectura == "si") ? "checked":"" ?>>
  <label class="form-check-label" for="permitirlectura1">Si</label>
</div>
<div class="form-check">
  <input class="form-check-input <?php if (isset($alertas["danger"]["permitirlectura"])) echo "is-invalid" ?>" value="no" type="radio" name="permitirlectura" id="permitirlectura2" <?php echo ($proyecto->permitirlectura == "no") ? "checked":"" ?>>
  <label class="form-check-label" for="permitirlectura2">No</label>
</div>
<?php if (isset($alertas["danger"]["permitirlectura"])): ?>
    <div class="invalid-feedback">
        <?php echo $alertas["danger"]["permitirlectura"] ?>
    </div>
<?php endif; ?>