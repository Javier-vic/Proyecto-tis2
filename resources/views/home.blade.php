@extends('layouts.navbar')

@section('content')
<div>
    <div class="border p-2">
        
        <div class="d-inline-block m-1">
            <div class="text-center">
                <i class="fa-solid fa-circle-exclamation text-danger fs-1"></i>
                <div>
                    <span class="text-danger">
                        Insumo en cero
                    </span>
                </div>
            </div>
        </div>
    
        <div class="d-inline-block m-1">
            <div class="text-center">
                <i class="fa-solid fa-triangle-exclamation text-warning fs-1"></i>
                <div>
                    <span class="text-warning">
                        insumo bajo en cantidad
                    </span>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection
