<form action="{{ url('/supply') }}" method="post">
    @csrf
    <label for="name_supply">Nombre</label>
    <input type="text" name="name_supply">
    <br>

    <label for="unit_meassurement">Unidad de medida</label>
    <input type="text" name="unit_meassurement">
    <br>

    <label for="quantity">Cantidad</label>
    <input type="float" name="quantity">
    <br>

    <label class="id_category_supply">Selecciona una categoria</label>
    <select name="id_category_supply">
    @foreach ($category_supplies as $category_supply)
        <option value="{{ $category_supply->id }}">{{ $category_supply->name_category }}</option>
    @endforeach
    </select>
    <br>
    <input type="submit" value="Crear">
</form>