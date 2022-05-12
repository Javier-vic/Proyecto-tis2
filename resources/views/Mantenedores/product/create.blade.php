<form action="{{ url('/product') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="" class="form-label">Nombre :</label>
        <input type="text" class="form-control" id="name_product" name="name_product"
            aria-describedby="name_product_help">
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Ingrese la cantidad del producto</label>
        <input type="number" class="form-control" id="stock" name="stock" aria-describedby="stock_help">
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Descripción : </label>
        <input type="text" class="form-control" id="description" name="description"
            aria-describedby="description_help">
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Imagen : </label>
        <input type="file" class="form-control" id="image_product" name="image_product"
            aria-describedby="name_product_help">
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Categoria del producto (Acá se debe desplegar una lista con los nombres de
            la tabla de la q vienen) : </label>
        <input type="text" class="form-control" id="id_category_product" name="id_category_product" value="1"
            aria-describedby="name_product_help">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
