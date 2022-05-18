
@extends('layouts.navbar')
@section('css_extra')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
@endsection
@section('content')
<form action="{{ route('order.update', $order->id) }}" method="POST" >

    @csrf
    {{method_field('PATCH') }}

    @include('Mantenedores.order.form')


</form>


@endsection