<div class="dropdown">
    <a role="button" class="btn dropdown-toggle" id="dropdown-default-primary" data-bs-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-fw fa-bars text-primary"></i>
    </a>

    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-default-primary">
        <button type="button" class="btn-view-producto dropdown-item text-main" value="{{ $_id }}" data-toggle="modal"
            data-target="#verProducto"><i class="fa-solid fa-magnifying-glass p-1"></i>Ver
            detalles</button>
            <button type="button" onclick="editCategorySupply({{$_id}})" class="dropdown-item  " ><i class="fa-solid fa-pen-to-square"></i> Editar categoria</button>
            <button type="button" onclick="deleteCategorySupply({{$_id}})" class="dropdown-item text-danger" ><i class="fas fa-trash-alt | text-danger | p-1"></i>Eliminar</button>


    </div>
</div>