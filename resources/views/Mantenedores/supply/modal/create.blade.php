<div class="modal fade" id="agregarInsumo" tabindex="-1" aria-labelledby="agregarInsumoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ingrese los datos del insumo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form onsubmit="addSupply(event)" method="POST" id="postForm">
                    @csrf
                    <div class="form-group">
                        <label for="" class="form-label">Nombre</label>
                        <input type="text" name="name_supply" class="form-control input-modal" id="name_supply">
                        <span class="text-danger createmodal_error" id="name_supply_errorCREATEMODAL"></span>

                    </div>
                    <div class="form-group">
                        <label for="unit_meassurement">Unidad de medida</label>
                        <select name="unit_meassurement" id="unit_meassurement" class="form-control input-modal">
                            <option value="Kg">Kilogramos</option>
                            <option value="g">Gramos</option>
                            <option value="L">Litros</option>
                            <option value="ml">Mililitros</option>
                            <option value="uds">Unidades</option>
                        </select>
                        <span class="text-danger createmodal_error" id="unit_meassurement_errorCREATEMODAL"></span>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Cantidad</label>
                        <input type="number" name="quantity" class="form-control input-modal" id="quantity">
                        <span class="text-danger createmodal_error" id="quantity_errorCREATEMODAL"></span>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Cantidad crítica</label>
                        <input type="number" name="critical_quantity" class="form-control input-modal" id="critical_quantity">
                        <span class="text-danger createmodal_error" id="quantity_errorCREATEMODAL"></span>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Selecciona una categoria</label>
                        <select name="id_category_supplies" class="form-select">
                            @foreach ($category_supplies as $category_supply)
                                <option value={{ $category_supply->id }} id="">{{ $category_supply->name_category }}</option>
                            @endforeach                       
                        </select>
                    </div>
                    <div class="form-group mt-2 mb-2">
                    </div>
                    <div class="form-group">
                        <button class = "btn btn-primary" type="submit" value="Agregar">Guardar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
