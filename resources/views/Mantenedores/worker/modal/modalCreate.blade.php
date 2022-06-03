<div class="modal fade" id="agregarTrabajador" tabindex="-1" aria-labelledby="agregarProductoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ingrese los datos del trabajador</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form onsubmit="saveWorker(event)" method="POST" id="postForm">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Nombre: </label>
                        <input type="text" class="form-control input-modal" id="name" name="name" 
                            aria-describedby="name">
                        <span class="text-danger createmodal_error" id="name_errorCREATEMODAL"></span>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Correo:</label>
                        <input type="text" class="form-control input-modal" id="email" name="email" 
                            aria-describedby="email_help">
                        <span class="text-danger createmodal_error" id="email_errorCREATEMODAL"></span>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Numero:</label>
                        <input type="number" value="569" class="form-control input-modal" id="phone" name="phone" 
                            aria-describedby="email_help">
                        <span class="text-danger createmodal_error" id="phone_errorCREATEMODAL"></span>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Direccion:</label>
                        <input type="text" class="form-control input-modal" id="address" name="address" 
                            aria-describedby="email_help">
                        <span class="text-danger createmodal_error" id="address_errorCREATEMODAL"></span>
                    </div>
                    <div class="mb-3">
                        <label for="id_role" class="form-label">Rol:</label>
                        <select name="id_role" class="form-select" id="id_role">
                            @foreach ($roles as $role)
                                <option value="{{$role->id}}">{{$role->name_role}}</option>
                            @endforeach
                        </select>
                        <span class="text-danger createmodal_error" id="name_product_errorCREATEMODAL"></span>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Contraseña:</label>
                        <input type="password" class="form-control input-modal" id="password" name="password" 
                            aria-describedby="password_help">
                        <span class="text-danger createmodal_error" id="password_errorCREATEMODAL"></span>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Confirmar contraseña:</label>
                        <input type="password" class="form-control input-modal" id="password_confirm" name="password_confirm" 
                            aria-describedby="password_help">
                        <span class="text-danger createmodal_error" id="password_confirm_errorCREATEMODAL"></span>
                    </div>
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </form>
            </div>
        </div>
    </div>
</div>