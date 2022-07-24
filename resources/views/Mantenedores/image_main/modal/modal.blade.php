<div class="modal fade" id="enviarCupon" tabindex="-1" aria-labelledby="enviarCuponLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ingrese publicidad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <form action="{{route('sendCoupon.store')}}" method="POST" enctype="multipart/form-data" >
                    @csrf

                    
                    <div class="mb-4 entradas">
                        <label  for="comment" class="form-label">Cantidad de correos por enviar :</label>
                        <input name="cantidad" type="text" class="form-control input-modal" 
                            class="form-control" id="sendCoupon" >
                            <span class="createmodal_error" id="address_errorCREATEMODAL"></span>
                    </div>
    
    
                    <div class="mb-4">
                        <label for="name_order" class="form-label">Tipo Cliente :</label>
                        <select id="mi-select" class="form-control" name="cliente">
    
                            <option value="0">Top mejores cliente</option>
                            <option value="1">Mejores cliente al azar</option>
                            <option value="2">Cliente sin compra</option>
                            <option value="3">Cliente al azar</option>
    
    
                        </select>
                    </div>

                    <div>
                        <label for="" class="form-label" >Cargar afiche</label>
                        <input type="file" class="form-control input-modal" id="foto" name="foto"
                            aria-describedby="name_product_help" accept="image/*">
                        
                    </div>
                
                    <button type="submit" class=" mt-3 btn btn-primary">Enviar cupón</button>
                </form>
                





            </div>
        </div>
    </div>
</div>
