<div class="modal fade" id="agregarCategoriaInsumo" tabindex="-1" aria-labelledby="agregarCategoriaInsumoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ingrese el nombre de la categoria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form onsubmit="addCategorySupply(event)" method="POST" id="postForm">
                    <div class="form-group">
                        @csrf
                        <label for="" class="form-label">Nombre</label>
                        <input type="text" name="name_category" class="form-control input-modal" id="idName">
                        <span class="text-danger createmodal_error" id="name_category_errorCREATEMODAL"></span>
                    </div>
                    <div class="form-group mt-2 mb-2">

                    </div>
                    <div class="form-group">
                        <button type="submit" class = "btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>