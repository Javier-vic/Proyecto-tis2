<div class="dropdown">
    <a role="button" class="btn dropdown-toggle" id="dropdown-default-primary" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-fw fa-bars text-primary"></i>
    </a>

    <div class="dropdown-menu dropdown-menu-right d-flex" aria-labelledby="dropdown-default-primary">
        <button type="button" class="btn-view-producto dropdown-item text-main" value="{{ $_id }}" data-toggle="modal"
            data-target="#verProducto"><i class="fa-solid fa-magnifying-glass p-1"></i>Ver
            detalles</button>
            <button type="button" onclick="editProduct({{$_id}})" class="btn btn-primary " ><i class="fa-solid fa-pen-to-square"></i> Editar producto</button>
            
            <form action="{{ route('product.destroy', ['product' => $_id]) }}" method="post">
                @csrf
                {{ method_field('DELETE') }}
                <button type="submit" class="dropdown-item text-danger" id="" value="Eliminar"><i
                    class="fas fa-trash-alt | text-danger | p-1"></i>Eliminar</button>
            </form>

    </div>
</div>
