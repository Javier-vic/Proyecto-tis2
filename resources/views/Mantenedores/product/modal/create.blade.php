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
                        <input type="text" class="form-control" id="name_product" name="name_product" value="FELIPE"
                            aria-describedby="name_product_help">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Cantidad </label>
                        <input type="number" class="form-control" id="stock" name="stock" value="100"
                            aria-describedby="stock_help">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Descripción </label>
                        <input type="text" class="form-control" id="description" name="description" value="DECSRIPSION"
                            aria-describedby="description_help">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Precio </label>
                        <input type="number" class="form-control" id="price" name="price" value="25000"
                            aria-describedby="description_help">
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
                        <input type="file" class="form-control" id="image_product" name="image_product"
                            aria-describedby="name_product_help">
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
