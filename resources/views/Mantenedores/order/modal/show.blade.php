<div class="modal fade" id="addOrder" tabindex="-1" aria-labelledby="addorderLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Orden</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="" class="form-label">Nombre </label>
                    <input readonly type="text" class="form-control" id="name_order" name="name_order"
                        aria-describedby="stock_help">
                </div>

                <div class="mb-3">
                    <label for="" class="form-label">Fecha </label>
                    <input readonly type="text" class="form-control" id="date" name="name_order"
                        aria-describedby="stock_help">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">metodo de pago </label>
                    <input readonly type="text" class="form-control" id="payment" name="name_order"
                        aria-describedby="stock_help">
                </div>

                <div class="mb-3">
                    <label for="" class="form-label">Delivery</label>
                    <input readonly type="text" class="form-control" id="dely" name="name_order"
                        aria-describedby="stock_help">
                </div>
                <table class="table table-light">
                  <thead>
                    <tr>

                        <th>Producto</th>
                    
                        <th>Cantidad</th>

                        <th>Subtotal</th>
                    
                        <th></th>
                      </tr>
                  </thead>
                    <tbody id="pruebaProductos">

                        
                    </tbody>
                </table>
                
                
            </div>
        </div>
    </div>