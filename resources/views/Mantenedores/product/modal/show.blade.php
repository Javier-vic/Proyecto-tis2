<div class="modal fade" id="verProducto" tabindex="-1" aria-labelledby="verProductoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verProductoLabel">Información de NOMBRE PRODUCTO</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @csrf
                <!-- <div class="mb-3">
                    <label for="" class="form-label">Nombre </label>
                    <input type="text" class="form-control" id="name_productVIEWMODAL" name="name_product"
                        aria-describedby="name_product_help">
                </div>  -->
                <div class="mb-3">
                    <label for="" class="form-label">Cantidad </label>
                    <input readonly type="number" class="form-control" id="stockVIEWMODAL" name="stock"
                        aria-describedby="stock_help">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Descripción </label>
                    <input readonly type="text" class="form-control" id="descriptionVIEWMODAL" name="description"
                        aria-describedby="description_help">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Precio </label>
                    <input readonly type="text" class="form-control" id="priceVIEWMODAL" name="price"
                        aria-describedby="description_help">
                </div>
                {{-- <div class="mb-3">
                    <label for="" class="form-label">Imagen </label>
                    <input type="file" class="form-control" id="image_productVIEWMODAL" name="image_product"
                        aria-describedby="name_product_he
                        lp">
                </div> --}}
                <div id="mostrarImagen"></div>
                <div class="mb-3">
                    <label for="" class="form-label">Categoría </label>
                    <input readonly type="text" class="form-control" id="category" name="category"
                        aria-describedby="name_product_help">
                </div>

            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div> --}}
        </div>
    </div>
</div>
