@extends('layouts.admin');

@section('title')
    حسابات الموردين
@endsection

@section('contentheader')
    الحسابات
@endsection

@section('contentheaderlink')
    <a href="{{ route('customers.index') }}"> حسابات الموردين </a>
@endsection

@section('contentheaderactive')
    تعديل
@endsection

@section('content')
    <div class="card">

        <div class="card-header">
            <h3 class="card-title card_title_center">تعديل حساب المورد</h3>
        </div>

        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger text-center">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('suppliers.update', $data->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div>

                    <div class="row mb-2">

                        <div class="form-group col-sm-6">
                            <label>اسم الحساب </label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $data->name) }}">

                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label>العنوان </label>
                            <input type="text" name="address" class="form-control"
                                value="{{ old('address', $data->address) }}">

                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="row mb-2">

                        <div class="form-group col-sm-6">
                            <label>الفئه التابع لها </label>
                            <select name="category_id" class="form-control">
                                <option value="" disabled>اختر الفئه </option>

                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @if ($category->id == $data['supplier_category_id']) selected @endif>
                                        {{ $category->name }} </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="form-group col-sm-6">
                            <label>حاله التفعيل</label>

                            <select name="active" class="form-control">
                                <option value="" disabled>اختر الحاله</option>

                                <option value="1" @selected(old('active', $data->active) == 1)>
                                    مفعل
                                </option>

                                <option value="0" @selected(old('active', $data->active) == 0)>
                                    مؤرشف وغير مفعل
                                </option>
                            </select>

                            @error('active')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="form-group col-sm-6">
                        <label>الملاحظات</label> <br>

                        <textarea name="notes" style="height: 80px; width: 580px">{{ old('notes', $data->notes) }}</textarea>

                        @error('notes')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>



                </div>

                <button type="submit" class="btn btn-primary m-5 p-2 col-sm-5">
                    تحديث
                </button>

                <a href="{{ route('suppliers.index') }}" class="btn btn-secondary m-4 p-2 col-sm-5">
                    رجوع
                </a>

            </form>

        </div>

    </div>
@endsection

@section('script')
@endsection
