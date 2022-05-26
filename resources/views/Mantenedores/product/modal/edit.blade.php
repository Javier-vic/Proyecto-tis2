<div class="modal fade" id="editProducto" tabindex="-1" aria-labelledby="editProductoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data" id="formEdit">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Nombre </label>
                        <input type="text" class="form-control input-modal" id="name_productEDIT" name="name_product" 
                            aria-describedby="name_product_help">
                    <span class="text-danger editmodal_error" id="name_product_errorEDITMODAL"></span>
                </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Cantidad </label>
                        <input type="number" class="form-control input-modal" id="stockEDIT" name="stock" 
                            aria-describedby="stock_help">
                    <span class="text-danger editmodal_error" id="stock_errorEDITMODAL"></span>
                </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Descripción </label>
                        <input type="text" onkeyup="countChar(this)" class="form-control input-modal text-limit" id="descriptionEDIT" name="description" 
                            aria-describedby="description_help" minlength="1" maxlength="500">
                    <span class="text-danger editmodal_error" id="description_errorEDITMODAL"></span>
                    <span class="text-danger d-none" id="text-limit_errorEDIT">Se ha alcanzado el limite de texto.</span>
                </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Precio </label>
                        <input type="number" class="form-control input-modal" id="priceEDIT" name="price" 
                            aria-describedby="description_help">
                    <span class="text-danger editmodal_error" id="price_errorEDITMODAL"></span>
                </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Categoria </label><br>

                        <select id="categoryEDIT" name="id_category_product" class="form-select">
                            @foreach ($category_products as $category_product)
                                <option value={{ $category_product->id }} id="">{{ $category_product->name }}</opti>
                            @endforeach
                        </select>
                    </div>
                    <div id="image_productEDITVIEW"></div>
                    <div class="mb-3 mt-2">
                        <input type="file" class="form-control input-modal" id="image_productEDIT" name="image_product"
                            aria-describedby="name_product_help" accept="image/*">
                    <span class="text-danger editmodal_error" id="image_product_errorEDITMODAL"></span>
                </div>
                 

                    <button class="btn btn-primary">Agregar</button>
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
    if (len >= 500) {
      val.value = val.value.substring(0, 500);
      $(".text-limit").addClass('is-invalid')
      $("#text-limit_errorEDIT").removeClass('d-none')
    } else {
      $("#description_errorEDITMODAL").empty();
      $("#text-limit_errorEDIT").addClass('d-none')
    $(".text-limit").removeClass('is-invalid')
      $('#charNum').text(500 - len);
    }
  };
  </script>
