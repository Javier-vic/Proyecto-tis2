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
                        <input type="text" class="form-control" id="name_productEDIT" name="name_product" 
                            aria-describedby="name_product_help">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Cantidad </label>
                        <input type="number" class="form-control" id="stockEDIT" name="stock" 
                            aria-describedby="stock_help">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Descripción </label>
                        <input type="text" class="form-control" id="descriptionEDIT" name="description" 
                            aria-describedby="description_help">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Precio </label>
                        <input type="number" class="form-control" id="priceEDIT" name="price" 
                            aria-describedby="description_help">
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
                    <div class="mb-3">
                        <input type="file" class="form-control" id="image_productEDIT" name="image_product"
                            aria-describedby="name_product_help">
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
