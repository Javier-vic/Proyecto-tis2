<div class="dropdown">
    <a role="button" class="btn dropdown-toggle" id="dropdown-default-primary" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-fw fa-bars text-primary"></i>
    </a>

    <div class="dropdown-menu dropdown-menu-right d-flex" aria-labelledby="dropdown-default-primary">
        {{-- <a class="dropdown-item"><i class="fas fa-share | mr-2"></i>Ver detalle</a> --}}
        <button type="button" class="btn-view-producto dropdown-item text-main" value="{{ $_id }}" data-toggle="modal"
            data-target="#verProducto"><i class="fa-solid fa-magnifying-glass p-1"></i>Ver
            detalles</button>
{{-- 
        <button type="button" class="dropdown-item btn-edit-producto" value="{{ $_id }}" data-toggle="modal"
            data-target="#editProducto">Editar<i class="fa-solid fa-pen-to-square"></i> --}}

            <form action="{{ route('product.edit', ['product' => $_id]) }}">
            @csrf
            {{ method_field('PATCH') }}
            <button type="submit" class="dropdown-item" ><i class="fa-solid fa-pen-to-square p-1"></i>Editar</button>
        </form>
            <form action="{{ route('product.destroy', ['product' => $_id]) }}" method="post">
                @csrf
                {{ method_field('DELETE') }}
                <button type="submit" class="dropdown-item text-danger" id="" value="Eliminar"><i
                    class="fas fa-trash-alt | text-danger | p-1"></i>Eliminar</button>
            </form>

    </div>
</div>
