<div class="dropdown">
    <a role="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="dropdown-default-primary"><i class="fa fa-fw fa-bars text-primary"></i></a>
 
    <div class="dropdown-menu dropdown-menu-right"  aria-labelledby="dropdown-default-primary">
            <button type="button" onclick="editCategory({{$_id}})"class="btn btn-primary " ><i class="fa-solid fa-pen-to-square"></i> Editar categoría</button>
            <button type="submit" onclick="deleteCategory({{$_id}})" class="dropdown-item text-danger" ><i class="fas fa-trash-alt | text-danger | p-1"></i>Eliminar</button>

    </div>
</div>

