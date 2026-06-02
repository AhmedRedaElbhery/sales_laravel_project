@extends('layouts.admin');

@section('title')
الضبط العام
@endsection

@section('contentheader')
الضبط
@endsection

@section('contentheaderlink')
<a href="{{ route('admin.dashboard') }}"> الضبط </a>
@endsection

@section('content')
عرض الضبط
@endsection

@section('contentheaderactive')
عرض
@endsection