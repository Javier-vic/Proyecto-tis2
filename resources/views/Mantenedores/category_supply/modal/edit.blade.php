<div class="modal fade" id="editCategorySupply" tabindex="-1" aria-labelledby="editCategorySupplyLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ingrese el nuevo nombre de la categoria:</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
            <form onsubmit="" method="POST" id="EditForm">
                @csrf
                <div class="form-group">
                    <label for="" class="form-label"></label>
                    <input type="text" name="name_category" class="form-control input-modal" id="name_categoryEdit" name="name">
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