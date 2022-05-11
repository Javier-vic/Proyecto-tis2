<form action="{{ url('/category_supply') }}" method="post">
    @csrf
    <label for="category"></label>
    <input type="text" name="name_category">
    <input type="submit" value="Crear">
</form>