
        <td class="row d-flex">
            <button type="button" class="btn-view-producto btn btn-primary btn-sm " value="{{ $_id }}" data-toggle="modal"
                data-target="#verProducto"><i class="fa-solid fa-magnifying-glass p-1"></i>Ver
                detalles</button>
            <button type="button" onclick="editProduct({{$_id}})" class="btn btn-success btn-sm" ><i class="fa-solid fa-pen-to-square"></i> Editar producto</button>
            <button type="button" onclick="deleteProduct({{$_id}})" class=" btn btn-danger btn-sm" ><i class="fas fa-trash-alt | text-white | p-1"></i>Eliminar</button>
        </td>
