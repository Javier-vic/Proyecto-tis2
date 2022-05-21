<div class="modal fade" id="editCategoria" tabindex="-1" aria-labelledby="verProductoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryLabel">Editar categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form  method="POST" onsubmit="" enctype="multipart/form-data" id="formEdit" onsubmit="">
                @csrf
            <div class="modal-body">
                <div class="mb-3">
                    <input type="hidden" class="form-control" id="idEDITMODAL" name="id" class="mb-3">
                    <label for="" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nameEDITMODAL" name="name"
                        aria-describedby="name_product_help">
                </div>
            <button id="btnEDITMODAL" class="btn btn-primary">Editar</button>

            </div>
        </form>

        </div>
    </div>
</div>
