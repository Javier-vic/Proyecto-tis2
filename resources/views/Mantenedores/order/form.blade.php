    <label for="name_order">nombre orden</label>
    <input type="text" name="name_order" id="name_order" value="{{isset($order -> name_order)}}" >

<br>

    <label for="total">total</label>
    <input type="text" name="total" id="" value="{{isset($order -> total)}}">
        
<br>

    <label for="order_status">estado orden</label>
    <input type="text" name="order_status" id="" value="{{isset($order -> name_order)}}">
    
<br>

    <label for="pick_up">retiro </label>
    <select id="pick_up" name="pick_up" value = "{{isset($order->pick_up) }}">

        <option value="no">no</option>
        <option value="si">si</option>
    
    </select>
    
<br>

    <label for="payment_method">metodo de pago:</label>
    <select id="payment_method" name="payment_method" value="{{ isset($order->payment_method)}}">

        <option value="Efectivo">Efectivo</option>
        <option value="Credito">Credito</option>
        <option value="Debito">Debito</option>
    
    </select>

<br>


    <label for="comment">comentario</label>
    <input type="text" name="comment" id="comment" value="{{isset($order->comment)}}">    
<br>

    <input type="submit" value= "Guardar configuracion">

<br>
