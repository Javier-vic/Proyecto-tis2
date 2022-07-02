<div class="modal fade" id="enviarCupon" tabindex="-1" aria-labelledby="enviarCuponLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ingrese la configuracion del rol</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <form onsubmit="sendCoupon(event)" entype="multipart/form-data" >
                    @csrf

                    <div class="mb-4">
                        <label for="name_order" class="form-label">Cupon a enviar :</label>
                        <select id="mi-select" class="form-control" name="pick_up">
    
                            <option value="QRE">QER</option>
    
    
                        </select>
                    </div>
    
                    <div class="mb-4 entradas">
                        <label for="comment" class="form-label">Cantidad de correos por enviar :</label>
                        <input type="number" class="form-control input-modal" 
                            class="form-control" id="sendCoupon" >
                            <span class="createmodal_error" id="address_errorCREATEMODAL"></span>
                    </div>
    
    
                    <div class="mb-4">
                        <label for="name_order" class="form-label">Tipo Cliente :</label>
                        <select id="mi-select" class="form-control" name="pick_up">
    
                            <option value="1">Top mejores cliente</option>
                            <option value="2">Mejores cliente al azar</option>
                            <option value="3">Cliente sin compra</option>
                            <option value="4">Cliente al azar</option>
    
    
                        </select>
                    </div>
                
                    <button type="submit" class=" mt-3 btn btn-primary">Enviar cupón</button>
                </form>
                





            </div>
        </div>
    </div>
</div>
