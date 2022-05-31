<div class="dropdown">
    <a role="button" class="btn dropdown-toggle" id="dropdown-default-primary" data-bs-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-fw fa-bars text-primary"></i>
    </a>

    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-default-primary">
            <button type="button" onclick="editSupply({{$_id}})" class=" btn btn-success btn-sm w-95 m-1" ><i class="fa-solid fa-pen-to-square"></i> Editar insumo</button>
            <button type="button" onclick="deleteSupply({{$_id}})" class="btn btn-danger btn-sm w-95 m-1" ><i class="fas fa-trash-alt  p-1"></i>Eliminar</button>
    </div>
</div>