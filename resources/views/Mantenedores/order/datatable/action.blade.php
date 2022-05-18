
    <div class="container">
        
       <div  class="row">
            <div class="col">
                <form action="{{ route('order.edit', ['order' => $_id]) }}">
                    @csrf
                    {{ method_field('PATCH') }}
                    <input type="submit" class="btn btn-primary" value="Editar">
            </div>
       
            <div class="col mx-0">
                <form action="{{ route('order.destroy', ['order' => $_id]) }}" method="post">
                    @csrf
                    {{ method_field('DELETE') }}
                    <input type="submit" class="btn btn-danger" id="" value="Eliminar">
                   
            </form>


            </div>
            
        </div>
    </div>


