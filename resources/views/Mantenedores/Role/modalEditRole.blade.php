<div class="modal fade" id="editRole" tabindex="-1" aria-labelledby="editRoleLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ingrese la nueva configuración del Rol:</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="editForm" enctype="multipart/form-data">
                    <input type="hidden" name="idRole">
                    <div class="form-group">
                        {{ Form::label('Nombre del rol','',['class'=>'form-label']) }}
                        {{ Form::text('name_role',$role->name_role,['class'=>'form-control','id'=>'editName'])}}
                    </div>
                    {!! Form::token() !!}
                    <div class="form-group mt-2 mb-2" >
                        {{Form::label('Permisos','',['class'=>'form-label']) }}
                        <div id='editPermits'>
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::submit('Editar Rol',['class'=>'btn btn-primary']) }}
                    </div>
                </form>
            </div>
        </div>
    </div>