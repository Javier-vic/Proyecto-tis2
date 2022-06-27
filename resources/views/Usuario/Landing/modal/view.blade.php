<div class="modal fade" id="viewOrder" tabindex="-1" aria-labelledby="addorderLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header aa">
                <img src="https://tolivmarket-production.s3.sa-east-1.amazonaws.com/companies/logos/8a17cb17fcb7d1012e47f83078ee24b603fd0fa1d9628ad486d5cb43bacbb81c.jpg" alt="" width="75" height="75">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body aa">
                <div class="mb-3">
                    <label for="" class="form-label fw-bold fs-2">Gracias por tu compra, </label>
                    <input readonly type="text" class="view-input fw-bold fs-2" id="name_order" name="name_order" aria-describedby="stock_help">
                </div>

                <div class="mb-3">
                    <label for="" class="form-label">Este pedido fue relizado el</label>
                    <input readonly type="text" class="view-input" id="date" name="name_order" aria-describedby="stock_help">
                </div>
                
                <div class="mb-1">
                    <label for="" class="form-label col-lg-5 text-center fs-4">Total</label>
                    <input readonly type="text" class="view-input col-lg-5 text-center fs-4" id="total" name="name_order" aria-describedby="stock_help">
                </div>
                
                <hr>
                
                <table class="table view-input">
                    <thead class=" view-input">
                        <tr>
                            
                            <th>producto</th>
                            
                            <th>Cantidad</th>
                            
                            <th>subtotal</th>
                            
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="pruebaProductos">
                        
                        
                    </tbody>
                </table>
                
                <div class="mb-3">
                    <label for="" class="form-label fw-bold">metodo de pago: </label>
                    <input readonly type="text" class="view-input" id="payment" name="name_order" aria-describedby="stock_help">
                </div>

                <div class="mb-3">
                    <label for="" class="form-label fw-bold">Delivery:</label>
                    <input readonly type="text" class="view-input" id="dely" name="name_order" aria-describedby="stock_help">
                    <input readonly type="text" class="view-input fs-5" id="dely_address" name="name_order" aria-describedby="stock_help">
                </div>
                
            </div>
        </div>
    </div>