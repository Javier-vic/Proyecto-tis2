<div class="modal fade" id="agregarCupon" tabindex="-1" aria-labelledby="agregarProductoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ingrese los datos del producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form onsubmit="createCoupon(event)" method="POST" enctype="multipart/form-data" id="formCreate">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Código del cupón </label>
                        <input type="text" class="form-control input-modal" id="code" name="code"
                            aria-describedby="name_product_help" placeholder="RAMENDASHI12">
                        <span class="text-danger createmodal_error" id="code_errorCREATEMODAL"></span>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Porcentaje de descuento </label>
                        <div class="d-flex">
                            <input type="range" class="form-range input-modal" id="percentage" name="percentage"
                                aria-describedby="stock_help" value="1" min="1" max="100" step="1"
                                oninput="percentageAmount.value=percentage.value" />
                            <input class="ms-3" id="percentageAmount" type="number" value="1" min="1"
                                max="100" oninput="percentage.value=percentageAmount.value" />
                        </div>
                        <span class="text-danger createmodal_error" id="percentage_errorCREATEMODAL"></span>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Fecha de emisión </label>
                        <input type="date" class="form-control input-modal emited" id="emited" name="emited"
                            aria-describedby="description_help">
                        <span class="text-danger createmodal_error" id="emited_errorCREATEMODAL"></span>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Fecha de caducidad </label>
                        <input type="date" class="form-control input-modal caducity" id="caducity" name="caducity"
                            aria-describedby="description_help">
                        <span class="text-danger createmodal_error" id="caducity_errorCREATEMODAL"></span>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Cantidad de cupones </label>
                        <input type="text" class="form-control input-modal" id="quantity" name="quantity"
                            aria-describedby="description_help" placeholder="100">
                        <span class="text-danger createmodal_error" id="quantity_errorCREATEMODAL"></span>
                    </div>




                    <button type="submit" class="btn btn-primary">Crear</button>
                </form>
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div> --}}
        </div>
    </div>
</div>
