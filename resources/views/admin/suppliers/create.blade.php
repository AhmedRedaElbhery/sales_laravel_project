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
    إضافة
@endsection

@section('content')
    <div class="card">

        <div class="card-header">
            <h3 class="card-title card_title_center">إضافة حساب مورد جديد</h3>
        </div>

        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger text-center">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('suppliers.store') }}" method="POST">
                @csrf
                <div>
                    <div class="row mb-2">

                        <div class="form-group col-sm-6">
                            <label>اسم الحساب </label>
                            <input type="text" name="name" class="form-control"  value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label>العنوان </label>
                            <input type="text" name="address" class="form-control"  value="{{ old('address') }}">
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                    </div>


                    <div class="row mb-2">

                        <div class="form-group col-sm-6">
                            <label>حاله التفعيل </label>
                            <select name="active" class="form-control" >
                                <option value="" selected disabled>اختر الحاله </option>
                                <option value="0"  @selected(old('active') === '0')> مفعل </option>
                                <option value="1"  @selected(old('active') == 1)> مؤرشف وغير مفعل </option>
                            </select>
                            @error('active')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label>الفئه التابع لها </label>
                            <select name="category_id" class="form-control" >
                                <option value="" selected disabled>اختر الفئه </option>

                                @foreach($supplier_category as $category)
                                <option value="{{ $category->id }}" >{{ $category->name }} </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                    </div>

                    <div class="row mb-2">

                        <div class="form-group col-sm-6">
                            <label>حاله الحساب </label>
                            <select name="start_balance_status" id="start_balance_status" class="form-control" >
                                <option value="" selected disabled>اختر حاله الحساب </option>
                                <option value="1"  @selected(old('start_balance_status') == 1)> دائن </option>
                                <option value="2" @selected(old('start_balance_status') == 2)> مدين </option>
                                <option value="3" @selected(old('start_balance_status') == 3)> متزن </option>
                            </select>
                            @error('start_balance_status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="form-group col-sm-6">
                            <label>رصيد اول المده </label> <br>
                            <input style="width: 570px; height: 38px" type="number" name="start_balance" id="start_balance"
                            placeholder="رصيد الحساب" value="{{ old('start_balance') }}">
                            @error('start_balance')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                    </div>

                    <div class="form-group col-sm-6">
                        <label>الملاحظات </label> <br>
                        <textarea name="notes" style="height: 100px; width: 560px"></textarea>
                        @error('notes')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <button type="submit" class="btn btn-primary m-5 p-2 col-sm-5">
                    حفظ
                </button>

                <a href="{{ route('suppliers.index') }}" class="btn btn-secondary m-4 p-2 col-sm-5">
                    رجوع
                </a>

            </form>

        </div>

    </div>
    </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            $('#start_balance_status').change(function() {

                if ($(this).val() == 3) {
                    $('#start_balance').val(0);
                }

            });

        });
    </script>
@endsection
