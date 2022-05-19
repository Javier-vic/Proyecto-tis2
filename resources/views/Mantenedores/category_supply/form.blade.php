<form onsubmit="addCategorySupply(event)" method="POST" id="postForm" enctype="multipart/form-data">
    <div class="form-group">
        {{ Form::label('Nombre de la categoria','',['class'=>'form-label']) }}
        {{ Form::text('name_category','',['class'=>'form-control','id'=>'idName'])}}
    </div>
    {!! Form::token() !!}
    <div class="form-group mt-2 mb-2">

    </div>
    <div class="form-group">
        {{ Form::submit('Guardar Categoria',['class'=>'btn btn-primary']) }}
    </div>
</form>