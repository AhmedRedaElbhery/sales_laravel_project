@extends('layouts.admin')

@section('title')
    تعديل فئات الاصناف
@endsection

@section('contentheader')
تعديل فئات الاصناف
@endsection

@section('contentheaderlink')
    <a href="{{ route('category.index') }}"> فئات الاصناف </a>
@endsection

@section('contentheaderactive')
    تعديل بيانات فئات الاصناف
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title card_title_center">تعديل بيانات فئات الاصناف </h3>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger text-center">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('category.update',$data['id']) }}" method="POST">
                        @csrf
                        @method('put')

                        <div class="form-group">
                            <label>اسم الفئه </label>
                            <input type="text" name="name" class="form-control" value="{{ $data->name }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>حالة التفعيل</label>

                            <select name="active" class="form-control">
                                <option value="" disabled>اختر الحاله</option>

                                <option value="1"
                                    {{ old('active', $data->active) == 1 ? 'selected' : '' }}>
                                    مفعل
                                </option>

                                <option value="0"
                                    {{ old('active', $data->active) == 0 ? 'selected' : '' }}>
                                    معطل
                                </option>
                            </select>

                            @error('active')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            حفظ التعديلات
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
