@extends('layouts.admin')

@section('title')
    إضافة فئه فواتير جديده
@endsection

@section('contentheader')
فئات الاصناف
@endsection

@section('contentheaderlink')
    <a href="{{ route('category.index') }}">  فئات الاصناف </a>
@endsection

@section('contentheaderactive')
    إضافة
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title card_title_center">إضافة فئات اصناف جديده</h3>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger text-center">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('category.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>اسم الصنف </label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>حالة التفعيل</label>
                            <select name="active" class="form-control">
                                <option value="" selected disabled>اختر الحاله</option>
                                <option value="1">مفعل</option>
                                <option value="0">معطل</option>
                            </select>
                            @error('active')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary m-2">
                            حفظ
                        </button>

                        <a href="{{ route('category.index') }}" class="btn btn-secondary">
                            رجوع
                        </a>

                    </form>

                </div>

            </div>
        </div>
    </div>
@endsection
