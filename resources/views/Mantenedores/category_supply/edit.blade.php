<form action="{{ url( '/category_supply/'.$category_supply->id ) }}" method="post">
    @csrf
    @method('PATCH')
    <label for="category"></label>
    <input type="text" name="name_category" value="{{ $category_supply->name_category }}">
    <input type="submit" value="Guardar">
</form>