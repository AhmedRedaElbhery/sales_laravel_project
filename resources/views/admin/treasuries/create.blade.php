@extends('layouts.admin')

@section('title')
    إضافة خزنة
@endsection

@section('contentheader')
    الخزن
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin.treasuries.index') }}"> الخزن </a>
@endsection

@section('contentheaderactive')
    إضافة
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">إضافة خزنة جديدة</h3>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger text-center">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.treasuries.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>اسم الخزنة</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>هل رئيسية؟</label>
                            <select name="is_master" class="form-control">
                                <option value="" selected disabled>اختر النوع</option>
                                <option value="0">لا</option>
                                <option value="1">نعم</option>
                            </select>
                            @error('is_master')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>رقم آخر إيصال صرف لهذه الخزنه</label>
                            <input type="number" name="last_isal_exchange" class="form-control" value="">
                            @error('last_isal_exchange')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>رقم آخر إيصال تحصيل لهذه الخزنه</label>
                            <input type="number" name="last_isal_collect" class="form-control" value="">
                            @error('last_isal_collect')
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

                        <button type="submit" class="btn btn-primary">
                            حفظ
                        </button>

                        <a href="{{ route('admin.treasuries.index') }}" class="btn btn-secondary">
                            رجوع
                        </a>

                    </form>

                </div>

            </div>
        </div>
    </div>
@endsection
