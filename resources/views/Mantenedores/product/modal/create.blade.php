<div class="modal fade" id="agregarProducto" tabindex="-1" aria-labelledby="agregarProductoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ingrese los datos del producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form onsubmit="createProduct(event)" method="POST" enctype="multipart/form-data" id="formCreate">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Nombre </label>
                        <input type="text" class="form-control input-modal" id="name_product" name="name_product"
                            aria-describedby="name_product_help">
                        <span class="text-danger createmodal_error" id="name_product_errorCREATEMODAL"></span>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Cantidad </label>
                        <input type="text" class="form-control input-modal" id="stock" name="stock"
                            aria-describedby="stock_help">
                        <span class="text-danger createmodal_error" id="stock_errorCREATEMODAL"></span>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Descripción </label>
                        {{-- <input type="text" onkeyup="countChar(this)" class="" id="description"
                            name="description" aria-describedby="description_help" minlength="1" maxlength="500"> --}}

                        <textarea name="description" id="description" class="form-control input-modal text-limit" cols="30" rows="10"
                            minlength="1" maxlength="500" onkeyup="countChar(this)"></textarea>

                        <span class="text-danger createmodal_error" id="description_errorCREATEMODAL"></span>
                        <span class="text-danger d-none" id="text-limit_error">Se ha alcanzado el limite de
                            texto.</span>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Precio </label>
                        <input type="text" class="form-control input-modal" id="price" name="price"
                            aria-describedby="description_help">
                        <span class="text-danger createmodal_error" id="price_errorCREATEMODAL"></span>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Categoria </label><br>

                        <select name="id_category_product" id="" name="id_category_product" class="form-select">
                            @foreach ($category_products as $category_product)
                                <option value={{ $category_product->id }} id="">{{ $category_product->name }}</opti>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Imagen </label>
                        <input type="file" class="form-control input-modal" id="image_product" name="image_product"
                            aria-describedby="name_product_help" accept="image/*">
                        <span class="text-danger createmodal_error" id="image_product_errorCREATEMODAL"></span>
                    </div>
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </form>
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div> --}}
        </div>
    </div>
</div>

<script type="text/javascript">
    function countChar(val) {
        var len = val.value.length;
        if (len >= 498) {
            val.value = val.value.substring(0, 498);
            $(".text-limit").addClass('is-invalid')
            $("#text-limit_error").removeClass('d-none')
        } else {
            $("#description_errorCREATEMODAL").empty();
            $("#text-limit_error").addClass('d-none')
            $(".text-limit").removeClass('is-invalid')
            $('#charNum').text(498 - len);
        }
    };
</script>
