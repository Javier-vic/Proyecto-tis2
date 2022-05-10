<div class="dropdown">
    <a role="button" class="btn dropdown-toggle" id="dropdown-default-primary" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-fw fa-bars text-primary"></i>
    </a>

    <div class="dropdown-menu dropdown-menu-right d-flex" aria-labelledby="dropdown-default-primary">
        <a class="dropdown-item"><i class="fas fa-share | mr-2"></i>Ver detalle</a>
        <form action="{{ route('product.edit', ['product' => $_id]) }}">
            @csrf
            {{ method_field('PATCH') }}
            <input type="submit" class="dropdown-item" value="Editar"><i class="fa-solid fa-pen-to-square"></i>
        </form>
        <form action="{{ route('product.destroy', ['product' => $_id]) }}" method="post">
            @csrf
            {{ method_field('DELETE') }}
            <input type="submit" class="dropdown-item text-danger" id="" value="Eliminar"><i
                class="fas fa-trash-alt | text-danger | mr-2"></i>
        </form>

    </div>
</div>
