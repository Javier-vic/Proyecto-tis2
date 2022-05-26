
    <div class="container">
        
        
       <div  class="row">
            <div class="col">

                <button type="button" onclick="showOrder({{ $_id }})"  class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addOrder"> Detalles </button>
            </div>
       
            <div class="col">
                <form action="{{ route('order.edit', ['order' => $_id]) }}">
                        @csrf
                        {{ method_field('PATCH') }}
                        <input type="submit" class="btn btn-primary" value="Editar">
                
                </form>
            </div>

            
            <div class="col mx-0">
                
               <button type="submit" class = "btn btn-danger" onclick="deleteOrder({{$_id}}) ">borrar</button>


            </div>
            
           
        </div>
    </div>


