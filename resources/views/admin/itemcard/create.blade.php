@extends('layouts.admin')

@section('title')
    إضافة صنف جديد
@endsection

@section('contentheader')
    الاصناف
@endsection

@section('contentheaderlink')
    <a href="{{ route('itemcard.index') }}"> الاصناف </a>
@endsection

@section('contentheaderactive')
    إضافة
@endsection

@section('content')
    <div class="card">

        <div class="card-header">
            <h3 class="card-title card_title_center">إضافة صنف جديد</h3>
        </div>

        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger text-center">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('itemcard.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label>باركود الصنف <span class="text-muted">(ف حاله عدم الادخال سيتم ادخاله اليا) </span>
                        </label>
                        <input type="text" name="barcode" class="form-control" value="{{ old('barcode') }}">
                        @error('barcode')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-sm-6">
                        <label>اسم الصنف </label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-sm-4">
                        <label>النوع </label>
                        <select name="item_type" class="form-control">
                            <option value="" selected disabled>اختر النوع </option>
                            <option value="1">تجزئه </option>
                            <option value="2"> استهلاكى بصلاحيه</option>
                            <option value="3">عهده</option>
                        </select>
                        @error('item_type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-sm-4">
                        <label>الفئه </label>
                        <select name="category_id" class="form-control">
                            <option value="" selected disabled>اختر الفئه </option>

                            @foreach ($categories as $item)
                                <option value="{{ $item->id }}">{{ $item->name }} </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-sm-4">
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
                </div>

                <button type="submit" class="btn btn-primary m-5 p-2 col-sm-5">
                    حفظ
                </button>

                <a href="{{ route('itemcard.index') }}" class="btn btn-secondary m-4 p-2 col-sm-5">
                    رجوع
                </a>

            </form>

        </div>

    </div>
    </div>
    </div>
@endsection
