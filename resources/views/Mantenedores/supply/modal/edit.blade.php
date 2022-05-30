<div class="modal fade" id="editSupply" tabindex="-1" aria-labelledby="agregarInsumoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ingrese los datos del insumo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="formEdit">
                    @csrf
                    <div class="form-group">
                        <label for="" class="form-label">Nombre</label>
                        <input type="text" name="name_supply" class="form-control input-modal" id="name_supplyEdit">
                    </div>
                    <div class="form-group">
                        <label for="unit_meassurement">Unidad de medida</label>
                        <input type="text" name="unit_meassurement" id="unit_meassurementEdit" class="form-control input-modal">
                    </div>
                    <div class="form-group">
                        <label for="quantity">Cantidad</label>
                        <input type="float" name="quantity" id="quantityEdit" class="form-control input-modal">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Selecciona una categoria</label>
                        <select name="id_category_supplies" class="form-select" id="id_category_suppliesEdit">
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
