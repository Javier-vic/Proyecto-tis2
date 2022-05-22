<div class="modal fade" id="editCategorySupply" tabindex="-1" aria-labelledby="editCategorySupplyLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ingrese el nuevo nombre de la categoria:</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
            <form onsubmit="addCategorySupply(event)" method="POST" id="postForm" enctype="multipart/form-data">
                <div class="form-group">
                    @csrf
                    <label for="category" class="form-label"></label>
                    <input type="text" name="name_category" class="form-nombre" id="idName">
                </div>
                <div class="form-group mt-2 mb-2">

                </div>
                <div class="form-group">
                    <input type="submit" value="Guardar categoria" class="btn btn-primary">
                </div>
            </form>

            </div>
        </div>
    </div>