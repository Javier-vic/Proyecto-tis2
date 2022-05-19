<div class="dropdown">
    <a role="button" class="btn dropdown-toggle" id="dropdown-default-primary" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-fw fa-bars text-primary"></i>
    </a>

    <div class="dropdown-menu dropdown-menu-right d-flex" aria-labelledby="dropdown-default-primary">
           
            <button type="submit" class="dropdown-item btn-edit-categoria" value="{{$_id}}" ><i class="fa-solid fa-pen-to-square p-1"></i>Editar</button>
        
            <form action="{{ route('category_product.destroy', ['category_product' => $_id]) }}" method="post">
                @csrf
                {{ method_field('DELETE') }}
                <button type="submit" class="dropdown-item text-danger" id="" value="Eliminar"><i
                    class="fas fa-trash-alt | text-danger | p-1"></i>Eliminar</button>
            </form>

    </div>
</div>
