<div class="modal fade" id="eliminarProyectoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar Proyecto</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Seguro/a que deseas eliminar el proyecto? Una vez eliminado no podrás recuperarlo.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $proyecto[0]->id;?>">
            <input type="hidden" name="tipo" value="eliminar">
            <input type="submit" class="btn btn-danger" value="Eliminar"/>
        </form>
      </div>
    </div>
  </div>
</div>