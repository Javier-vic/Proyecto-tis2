<table>

    <thead>
        <tr>
            <th>#</th>
            <th>name_category</th>
            <th>acciones</th>
        </tr>
    </thead>

    <tbody>
        @foreach($category_supplies as $category_supply)
        <tr>
            <td>{{ $category_supply->id }}</td>
            <td>{{ $category_supply->name_category }}</td>
            <td><a href="{{ url( '/category_supply/'.$category_supply->id.'/edit' ) }}">Editar</a> |             
                <form action="{{ url( '/category_supply/'.$category_supply->id ) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="submit" onclick="return confirm('¿Quieres borrar?')" value="borrar">
                </form>
            </td>          
        </tr>
        @endforeach
    </tbody>

</table>