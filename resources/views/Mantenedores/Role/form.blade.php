<form action="{{route('roles.store')}}" method="POST" id="postForm" enctype="multipart/form-data">
    <div class="form-group">
        {{ Form::label('Nombre del rol','',['class'=>'form-label']) }}
        {{ Form::text('name_role',$role->name_role,['class'=>'form-control','id'=>'idName'])}}
    </div>
    {!! Form::token() !!}
    <div class="form-group mt-2 mb-2">
        {{Form::label('Permisos','',['class'=>'form-label']) }}
        @foreach ($permits as $item)
            <div class="form-check form-switch">
                <input class="form-check-input" name="permits[]" value="{{$item->id}}" type="checkbox" id="{{$item->id}}">
                <label class="form-check-label" for="flexSwitchCheckDefault">{{ucfirst($item->tipe_permit)}}</label>
            </div>
        @endforeach
    </div>
    <div class="form-group">
        {{ Form::submit('Guardar Rol',['class'=>'btn btn-primary']) }}
    </div>
</form>