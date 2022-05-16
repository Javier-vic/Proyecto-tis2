<div class="modal fade" id="editProducto" tabindex="-1" aria-labelledby="verProductoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductoLabel">Información de NOMBRE PRODUCTO</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('product.modal.edit.store', ['product' => $idActual]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    {{ method_field('PATCH') }}
                    <input type="hidden" class="form-control" id="idEDITMODAL" name="id" class="mb-3">
                    <label for="" class="form-label">Nombre </label>
                    <input type="text" class="form-control" id="name_productEDITMODAL" name="name_product"
                        aria-describedby="name_product_help">
                    </>
                    <div class="mb-3">
                        <label for="" class="form-label">Cantidad </label>
                        <input type="number" class="form-control" id="stockEDITMODAL" name="stock"
                            aria-describedby="stock_help">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Descripción </label>
                        <input type="text" class="form-control" id="descriptionEDITMODAL" name="description"
                            aria-describedby="description_help">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Imagen </label>
                        <input type="file" class="form-control" id="image_productEDITMODAL" name="image_product"
                            aria-describedby="name_product_help">
                    </div>
                    <div id="mostrarImagenEDITMODAL"></div>
                    <div>
                        <input type="hidden" class="form-control" id="urlImagen" name="urlImagen">

                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Categoría </label>
                        <input type="text" class="form-control" id="categoryEDITMODAL" name="category"
                            aria-describedby="name_product_help">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>

                </form>

            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div> --}}
        </div>
    </div>
</div>
