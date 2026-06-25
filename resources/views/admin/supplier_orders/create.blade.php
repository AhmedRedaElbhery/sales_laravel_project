@extends('layouts.admin');

@section('title')
    المشتريات
@endsection

@section('contentheader')
    حركات مخزنيه
@endsection

@section('contentheaderlink')
    <a href="{{ route('supplier_orders.index') }}"> فواتير المشتريات </a>
@endsection

@section('contentheaderactive')
    إضافة
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title card_title_center">إضافة فاتوره جديد</h3>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger text-center">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('supplier_orders.store') }}" method="POST">
                        @csrf

                        <a href="{{ route('suppliers.create') }}" class="btn btn-primary text-white mb-2">إضافة حساب مورد
                            جديد</a>


                        <div class="form-group">
                            <label>اسم المورد </label> <br>
                            <select name="supplier_code" class="form-control">
                                <option value="" selected disabled>اختر الاسم</option>

                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->supplier_code }}" @selected(old('supplier_code') == $supplier->supplier_code)>
                                        {{ $supplier->name }}</option>
                                @endforeach
                            </select>
                            @error('supplier_code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>نوع الفاتوره </label>
                            <select name="pill_type" class="form-control">
                                <option value="" selected disabled>اختر نوع </option>
                                <option value="0" @selected(old('pill_type') === '0')>كاش</option>
                                <option value="1" @selected(old('pill_type') === '1')>اجل</option>
                            </select>
                            @error('pill_type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>رقم الفاتوره المسجل باصل فاتوره المشتريات</label> <br>
                            <input name="doc_number" class="form-control" type="text">
                            @error('doc_number')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="form-group row">


                            <div class="col-6">
                                <label>التاريخ </label> <br>
                                <input style="width: 550px; height: 40px" name="order_date" type="date"
                                    value="@php echo date('Y-m-d') @endphp">
                                @error('order_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="col-6">
                                <label>ملاحظات</label> <br>
                                <textarea name="notes" style="width: 550px"></textarea>
                                @error('notes')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                        </div>

                        <button type="submit" class="btn btn-primary m-2">
                            حفظ
                        </button>

                        <a href="{{ route('supplier_orders.index') }}" class="btn btn-secondary">
                            رجوع
                        </a>

                    </form>

                </div>

            </div>
        </div>
    </div>
@endsection
