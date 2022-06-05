<div class="dropdown">
    <a role="button" class="btn dropdown-toggle" id="dropdown-default-primary" data-bs-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-fw fa-bars text-primary"></i>
    </a>

    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-default-primary">
            <button type="button" onclick="showOrder({{ $_id }})" class=" btn btn-primary btn-sm w-95 m-1" data-bs-toggle="modal" data-bs-target="#addOrder"> <i class="fa-solid fa-magnifying-glass p-1"></i> Ver Detalles</button>
          
        @if ($order_status == 'Espera')
        <form action="{{ route('order.edit', ['order' => $_id]) }}">
            @csrf
            {{ method_field('PATCH') }}

            <button type="submit" class=" btn btn-success btn-sm w-95 m-1" > <i class="fa-solid fa-pen-to-square"></i>  Editar orden</button>
    
        </form>
        <button type="button" onclick="deleteOrder({{$_id}}) "class="btn btn-danger btn-sm w-95 m-1" ><i class="fas fa-trash-alt  p-1"></i>Eliminar</button>
            
        @endif
            
    </div>
</div>
