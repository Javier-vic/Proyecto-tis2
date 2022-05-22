<form action="{{ url('') }}" method="post">
    @csrf
    <label for="category"></label>
    <input type="text" name="name_category">
    <input type="submit" value="Crear">
</form>