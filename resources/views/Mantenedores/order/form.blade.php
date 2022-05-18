   
   
<div class="mb-4">
    <label for="name_order" class="form-label">Nombre pedido :</label>
    <input type="text" class="form-control" value="{{ isset($order -> name_order) }}" id="name_order" name="name_order" aria-describedby="name_product_help">
</div>
  

<div class="mb-4">
    <label for="order_status" class="form-label">Estado pedido :</label>
    <select id="order_status"  class="form-control" name="order_status" value = "{{isset($order->order_status) }}">

        <option value="Cocinando">Cocinando</option>
        <option value="Listo">Listo</option>
        <option value="Entregado">Entregado</option>
    
    </select>
</div>


<div class="mb-4">
    <label for="name_order" class="form-label">Despacho pedido :</label>
    <select id="pick_up"  class="form-control" name="pick_up" value = "{{isset($order->pick_up) }}">

        <option value="no">SI</option>
        <option value="si">NO</option>
    
    </select>
</div>

  
<div class="mb-4">
    <label for="name_order" class="form-label">Metodo de pago :</label>
    <select id="payment_method"  class="form-control" name="payment_method" aria-describedby="name_product_help" value="{{ isset($order->payment_method)}}">

        <option value="Efectivo">Efectivo</option>
        <option value="Credito">Credito</option>
        <option value="Debito">Debito</option>
    
    </select>

    <div class="mb-4">
        <label for="total" class="form-label">Total :</label>
        <input type="text"  class="form-control" value="{{ isset($order->total)}}" class="form-control" id="total" name="total" >
    </div>


    <div class="mb-4">
        <label for="comment" class="form-label">Comentario :</label>
        <input type="text"  class="form-control" value="{{ isset($order->comment) }}" class="form-control" id="comment" name="comment" >
    </div>



    <button type="submit" class="btn btn-primary">Realizar pedido</button>


