@extends('layouts.admin');

@section('title')
الرئيسيه
@endsection

@section('contentheader')
الرئيسيه
@endsection

@section('contentheaderlink')
<a href="{{ route('admin.dashboard') }}"> الرئيسيه </a>
@endsection

@section('content')
<div class="row"
    style="background-image: url('{{ asset('assets/admin/dash.jpg') }}');
           background-size: cover;
           background-repeat: no-repeat;">
</div>
@endsection

@section('contentheaderactive')
عرض
@endsection