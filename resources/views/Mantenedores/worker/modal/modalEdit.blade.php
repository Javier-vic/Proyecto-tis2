<div class="modal fade" id="editTrabajador" tabindex="-1" aria-labelledby="editTrabajadorLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Datos del trabajador</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form onsubmit="submitEdit(event)" method="POST" id="editForm">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Nombre: </label>
                        <input type="text" class="form-control input-modal" id="nameEdit" name="name" 
                            aria-describedby="name">
                        <span class="text-danger createmodal_error" id="name_errorEDITMODAL"></span>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Correo:</label>
                        <input type="text" class="form-control input-modal" id="emailEdit" name="email" 
                            aria-describedby="email_help">
                        <span class="text-danger createmodal_error" id="email_errorEDITMODAL"></span>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Numero:</label>
                        <input type="text" class="form-control input-modal" id="phoneEdit" name="phone" 
                            aria-describedby="email_help">
                        <span class="text-danger createmodal_error" id="phone_errorEDITMODAL"></span>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Direccion:</label>
                        <input type="text" class="form-control input-modal" id="addressEdit" name="address" 
                            aria-describedby="email_help">
                        <span class="text-danger createmodal_error" id="address_errorEDITMODAL"></span>
                    </div>
                    <div class="mb-3">
                        <label for="id_role" class="form-label">Rol:</label>
                        <select name="id_role" class="form-select" id="id_roleEdit">
                            @foreach ($roles as $role)
                                <option id="editSelectRole{{$role->id}}" value="{{$role->id}}">{{$role->name_role}}</option>
                            @endforeach
                        </select>
                        <span class="text-danger createmodal_error" id="name_product_errorEDITMODAL"></span>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="idChangePassword" name="changePassword" onchange="$('#changePasswordContainer').slideToggle();">
                            <label class="form-check-label" for="idChangePassword">¿Desea cambiar la contraseña?</label>
                        </div>
                    </div>
                    <div class="" id="changePasswordContainer" style="display:none;">
                        <div class="mb-3">
                            <label for="" class="form-label">Nueva contraseña:</label>
                            <input type="password" class="form-control input-modal" id="passwordEdit" name="password" 
                                aria-describedby="password_help">
                            <span class="text-danger createmodal_error" id="password_errorEDITMODAL"></span>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Confirmar nueva contraseña:</label>
                            <input type="password" class="form-control input-modal" id="password_confirmEdit" name="password_confirm" 
                                aria-describedby="password_help">
                            <span class="text-danger createmodal_error" id="password_confirm_errorEDITMODAL"></span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Editar</button>
                </form>
            </div>
        </div>
    </div>
</div>