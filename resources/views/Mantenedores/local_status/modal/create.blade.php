<div class="modal fade" id="localStatus" tabindex="-1" aria-labelledby="localStatusLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ingrese los horarios de atención</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form onsubmit="modifyStatus(event)" method="POST" enctype="multipart/form-data" id="formModify">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Horario de apertura </label>
                        <input type="date" class="form-control input-modal text-dark" id="opening" name="opening"
                            aria-describedby="opening_help">
                        <span class="text-danger createmodal_error" id="opening_errorCREATEMODAL"></span>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Horario de cierre </label>
                        <input type="date" class="form-control input-modal text-dark" id="closing" name="closing"
                            aria-describedby="closing_help">
                        <span class="text-danger createmodal_error" id="closing_errorCREATEMODAL"></span>
                    </div>
                    <p class="text-muted text-sm">*Durante las horas que se encuentren fuera de horario de apertura y
                        cierre no se podrán recibir compras en la página web</p>
                    <button type="submit" class="btn btn-primary">Modificar</button>
                </form>
            </div>
        </div>
    </div>
</div>
