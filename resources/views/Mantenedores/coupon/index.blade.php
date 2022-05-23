@extends('layouts.navbar')
@section('css_extra')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    
.coupon {
  position: relative;
  width: 400px;
  height: 160px;
  margin: 15px auto;
  background-image: 
    radial-gradient(circle at 1px 8px, transparent 6px, #ff9e6d 6px, #ff9e6d 0px), 
    radial-gradient(circle at 199px 8px, transparent 6px, #ff9e6d 6px, #ff9e6d 0px);
  background-size: 500px 18px;
  background-position: 0 0, 200px 0;
  background-repeat-x: no-repeat;
  font-size: 60px;
  color: #fff;
  font-weight: bold;
  line-height: 160px;
  padding-left: 60px;
  box-sizing: border-box;
  cursor: pointer;
}
.coupon::before {
  position: absolute;
  content: "";
  left: 400px;
  top: 0;
  bottom: 0;
  width: 0;
  border-left: 1px dashed #fff;
}
.coupon::after {
  position: absolute;
  font-size: 26px;
  width: 70px;
  top: 50%;
  right: 2%;
  transform: translate(-50%, -50%);
  line-height: 40px;
  letter-spacing: 5px;
}

</style>
@endsection

@section('content')
<div id="number">0</div>

<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarCupon">
    Crear cupón
</button>
<button type="button" class="btn btn-primary" onclick="refreshCoupons()">
    Actualizar cupones
</button>
    <div>@include('Mantenedores.coupon.modal.create')</div>
    <div class="row col-8 mx-auto" id="cuponContainer">
        @foreach ($coupons as $coupon )
        <div class="coupon col-12 " onclick="deleteCoupon({{$coupon->id}})" id="{{$coupon->id}}">
            <h3>{{$coupon->code}}</h3>
            <h5>Descuento del {{$coupon->percentage}}%</h5>
            <h5>Comienzo {{$coupon->caducity}}</h5>
            <h5>Caduca {{$coupon->emited}}</h5>
            <h5>Cantidad {{$coupon->quantity}}</h5>
        </div>
        @endforeach 
    </div>
      
@endsection

@section('js_after')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script type="text/javascript">

    //FUNCIÓN PARA CREAR CUPÓN
    const createCoupon = (e) => {
        e.preventDefault();
        var formData = new FormData(e.currentTarget);
            var  url = '{{ route("coupon.store") }}';
                $.ajax({
                type: "POST",
                url: url,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                    success: function(response, jqXHR) {
                        console.log(response)
                        console.log(response[1])
                        Swal.fire({
                        position: 'bottom-end',
                        icon: 'success',
                        title: 'Se creó el cupón correctamente.',
                        showConfirmButton: false,
                        timer: 2000,
                        backdrop: false,
                        heightAuto:false,
                    })
                    $('#cuponContainer').append(`
                        <div class="coupon col-12" onclick="deleteCoupon(${response[1]})" id="${response[1]}">
                            <h3>${response[0].code}</h3>
                            <h5>Descuento del ${response[0].percentage}%</h5>
                            <h5>Comienzo ${response[0].emited}</h5>
                            <h5>Caduca ${response[0].caducity}</h5>
                            <h5>Cantidad ${response[0].quantity}</h5>
                        </div>
                    `);
                    $('#agregarCupon').modal('hide');  
 
                    },
                   error: function( jqXHR, textStatus, errorThrown ) {
                    var text = jqXHR.responseJSON;
                    console.log(text)
                    $(".createmodal_error").empty()
                    $(".input-modal").addClass('is-valid')
                    $(".input-modal").removeClass('is-invalid')
                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'error',
                        title: "No se pudo crear el nuevo cupón.",
                        showConfirmButton: false,
                        timer: 2000,
                        backdrop: false
                    })
                    //AGREGA LAS CLASES Y ELEMENTOS DE INVALID
                    if(text){
                    $.each(text.errors, function(key,item){
                    $("#"+key+"_errorCREATEMODAL").append("<span class='text-danger'>"+item+"</span>")
                    $(`#${key}`).addClass('is-invalid');
                    $(`.${key}`).addClass('is-invalid');
                    });
                    }
                    //////////////////////////////////////

               }
            });
    }
     //////////////////////////////////////
     //ELIMINAR UN CUPÓN
     const deleteCoupon = (id) =>{
        Swal.fire({
            title: '¿Estás seguro de eliminar este cupón?',
            text: "No se puede revertir.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Borrar!',
            cancelButtonText: 'Cancelar',
            }).then((result)=>{
            url = '{{ route("coupon.destroy", ":coupon") }}';
            url = url.replace(':coupon', id);
            if(result.isConfirmed){
                $.ajax({
                type: "DELETE",
                url: url,
                error: function( jqXHR, textStatus, errorThrown ) {
                   var text = jqXHR.responseText;
                   Swal.fire({
                       position: 'bottom-end',
                       icon: 'error',
                       title: text,
                       showConfirmButton: false,
                       timer: 2000,
                       backdrop: false
                   })
               },
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                    success: function(response) {
                        Swal.fire(
                                'Borrado!',
                                'El cupón ha sido eliminado.',
                                'success'
                            )
                        $(`#${id}`).remove();
         

                    }
                });
            }
         
            })

     } 
     ////////////////////////////////////

     const refreshCoupons = () =>{
        var  url = '{{ route("coupon.refresh.coupon") }}';
                $.ajax({
                type: "GET",
                url: url,
                    success: function(response, jqXHR) {
                        console.log(response);
                        $('#cuponContainer').empty();
                    $('#agregarCupon').modal('hide');  
 
                    },
                   error: function( jqXHR, textStatus, errorThrown ) {
                    var text = jqXHR.responseJSON;
                    console.log(text)
                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'error',
                        title: "No se pudieron actualizar los cupones, revise su conexión internet.",
                        showConfirmButton: false,
                        timer: 2000,
                        backdrop: false
                    })
            

               }
            });

     }
    //////////////////////////////////////
    //FLATPICKR//////////////////////////////////////
   let emited = $("#emited").flatpickr({
        altInput: true,
        altFormat: 'j F, Y',
        dateFormat: 'd-m-Y',
        defaultDate: 'today',
        minDate : 'today',
        locale: locale(), //IDIOMA
        onChange: function(selectedDates, dateStr, instance) {
            caducity.set('minDate', dateStr);
            $(".caducity").removeClass('is-valid')

        },
    }
        
    );
    //////////////////////////////////////
    //////////////////////////////////////
   let caducity= $("#caducity").flatpickr({
        altInput: true,
        altFormat: 'j F, Y',
        dateFormat: 'd-m-Y',
        defaultDate: 'today',
        locale: locale(), //IDIOMA
        minDate : 'today',
    });
     //////////////////////////////////////
    //*                               +//
    //////////////////////////////////////

    //IDIOMA PARA FLATPICKR//////////////////////////////////////
    function locale() {
        return {
        firstDayOfWeek: 1,
        weekdays: {
          shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
          longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],         
        }, 
        months: {
          shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Оct', 'Nov', 'Dic'],
          longhand: ['Enero', 'Febreo', 'Мarzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        }};
    }
    //
</script>
@endsection