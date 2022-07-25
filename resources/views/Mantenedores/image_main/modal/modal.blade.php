<div class="modal fade" id="enviarCupon" tabindex="-1" aria-labelledby="enviarCuponLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ingrese publicidad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <form onsubmit="sendPublic(event)"  method="POST" enctype="multipart/form-data" >
                    @csrf
                    <div class="mb-4 entradas">
                        <label  for="comment" class="form-label">Cantidad de correos por enviar :</label>
                        <input name="cantidad" id="cantidad" type="text" class="form-control input-modal" 
                            class="form-control"  aria-describedby="cantidad_help" >
                            <span class="createmodal_error" id="cantidad_errorCREATEMODAL"></span>
                    </div>
    
    
                    <div class="mb-4">
                        <label for="name_order" class="form-label">Tipo Cliente :</label>
                        <select id="mi-select" class="form-control" name="cliente">
    
                            <option value="0">Top mejores cliente</option>
                            <option value="1">Todos los clientes</option>
                            <option value="2">Cliente sin compras</option>
                            <option value="3">Cliente al azar</option>
    
    
                        </select>
                    </div>

                    <div>
                        <label for="" class="form-label" >Cargar afiche</label>
                        <input type="file" class="form-control input-modal" id="foto" name="foto"
                            aria-describedby="foto_help"  accept="image/*">
                        <span class="text-danger createmodal_error" id="foto_errorCREATEMODAL"></span>
                            
                        
                    </div>

                    <div class="mt-5 d-flex d-none justify-content-center" id="loadingPublicida">

                        <div class="spinner-border left-50" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <button type="submit" class=" mt-3 btn btn-primary">Enviar Publicidad</button>
                </form>
            </div>
        </div>
    </div>
</div>
