@extends('layouts.navbar')

@section('titlePage')
    <h2>Importar insumos</h2>
@endsection

@section('content')
    <a href="{{ route('supply.index') }}" class="btn btn-secondary"><i class="fa-solid fa-arrow-left me-2"></i>Volver</a>
    <div class="text-center mb-5" id="excelImport">


        <div class="w-100 text-center mb-3"><button class="btn-secondary btn" id="instructionsSwitch"
                onclick="switchInstructions(event)">Ver
                instrucciones</button>
        </div>
        <div class="border border-success d-inline-block p-3 ">

            <form action="{{ route('supply.excel') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div>
                    <input type="file" name="import_file" id="import_file"
                        accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                        class="border border-2 me-3">
                    <button class="btn btn-success">Subir</button>
                    <p class="text-danger">
                        @if ($errors->any())
                            {{ $errors->first('message') }}
                        @endif
                    </p>
                </div>
                <hr>
                <a download href="{{ asset('storage/files/insumos.xlsx') }}" class="btn btn-secondary">Descargar
                    plantilla<i class="fa-solid fa-file-excel ms-2"></i> </a>
            </form>
        </div>
        <div class="d-none mt-3" id="instructions">
            <h5> 1.Descargar plantilla
            </h5>
            <h5> 2.Rellenar con datos (Leer notas)</h5>
            <h5> 3.Seleccionar y subir plantilla</h5>
        </div>
    </div>
@endsection

@section('js_after')
    <script>
        let counter = 1;
        switchInstructions = (e) => {
            if (counter % 2 != 0) {
                $('#instructions').removeClass('d-none')
                $('#instructionsSwitch').html('Ocultar instrucciones')
                counter++;

            } else {
                $('#instructions').addClass('d-none')
                $('#instructionsSwitch').html('Ver instrucciones')
                counter++;

            }
        }
    </script>
@endsection
