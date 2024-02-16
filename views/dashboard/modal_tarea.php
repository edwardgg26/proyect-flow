<div class="modal fade" id="modalTarea" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalTitle">Tarea</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div id="contenedorAlertas">
            
                    </div>
                    <div class="mb-3" id="campoTarea">
                        <label for="recipient-name" class="col-form-label">Tarea</label>
                        <input type="text" class="form-control" id="tarea">
                    </div>
                    
                    <div class="mb-3" id="campoFechaIni">
                        <label for="message-text" class="col-form-label">Fecha de inicio</label>
                        <input type="date" class="form-control" id="fechaInicio">
                    </div>
                    <div class="mb-4" id="campoFechaFin">
                        <label for="message-text" class="col-form-label">Fecha de fin</label>
                        <input type="date" class="form-control" id="fechaFin">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" id="agregartarea" class="btnFormulario btn btn-<?php echo $colores ?? "primary"?>" >Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>