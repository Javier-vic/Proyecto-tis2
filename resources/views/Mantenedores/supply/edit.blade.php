<form action="{{ url( '/supply/'.$supply->id ) }}" method="post">
    @csrf
    @method('PATCH')
    <label for="name_supply">Nombre</label>
    <input type="text" name="name_supply" value="{{ $supply->name_supply }}">
    <br>

    <label for="unit_meassurement">Unidad de medida</label>
    <input type="text" name="unit_meassurement" value="{{ $supply->unit_meassurement }}">
    <br>

    <label for="quantity">Cantidad</label>
    <input type="float" name="quantity" value="{{ $supply->quantity }}">
    <br>

    <label class="id_category_supply">Selecciona una categoria</label>
    <select name="id_category_supply">
    @foreach ($category_supplies as $category_supply)
        <option value="{{ $category_supply->id }}">{{ $category_supply->name_category }}</option>
    @endforeach
    </select>
    <br>
    <input type="submit" value="Guardar">
</form>