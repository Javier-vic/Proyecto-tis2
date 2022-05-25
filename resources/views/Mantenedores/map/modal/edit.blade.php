<div class="modal fade" id="editMap" tabindex="-1" aria-labelledby="verProductoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryLabel">Editar categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form  method="POST" enctype="multipart/form-data" id="formEdit">
                @csrf
            <div class="modal-body">
                <div class="mb-3">
                    <label for="" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="direccion" name="direccion"
                        aria-describedby="name_product_help" placeholder="Puren 596 Chillán, Ñuble">
                    <span class="text-danger editmodal_error" id="direccion_error"></span>
                    <input type="hidden" id="latitud" name="latitud">
                    <input type="hidden" id="longitud" name="longitud">
                </div>
            <button id="btnEDITMODAL" class="btn btn-primary">Editar</button>

            </div>
        </form>

        </div>
    </div>
</div>
