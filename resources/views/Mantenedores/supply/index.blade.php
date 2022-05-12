<table>

    <thead>
        <tr>
            <th>#</th>
            <th>name_supply</th>
            <th>unit_meassurement</th>
            <th>quantity</th>
            <th>name_category</th>
            <th>acciones</th>
        </tr>
    </thead>

    <tbody>
        @foreach($supplies as $supply)
        <tr>
            <td>{{ $supply->id }}</td>
            <td>{{ $supply->name_supply }}</td>
            <td>{{ $supply->unit_meassurement }}</td>
            <td>{{ $supply->quantity }}</td>
            <td>{{ $supply->id_category_supplies }}</td>
            <td><a href="{{ url( '/supply/'.$supply->id.'/edit' ) }}">Editar</a> |             
                <form action="{{ url( '/supply/'.$supply->id ) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="submit" onclick="return confirm('¿Quieres borrar?')" value="borrar">
                </form>
            </td>          
        </tr>
        @endforeach
    </tbody>

</table>