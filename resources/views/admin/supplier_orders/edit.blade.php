@extends('layouts.admin');

@section('title')
    المشتريات
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection


@section('contentheader')
    حركات مخزنيه
@endsection

@section('contentheaderlink')
    <a href="{{ route('supplier_orders.index') }}"> فواتير المشتريات </a>
@endsection

@section('contentheaderactive')
تعديل
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title card_title_center">تعديل فاتوره من مورد</h3>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger text-center">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('supplier_orders.update',$data->id) }}" method="POST">
                        @method('put')
                        @csrf

                        <div class="form-group">
                            <label>اسم المورد </label> <br>
                            <select name="supplier_code" class="form-control select2">
                                <option value="" selected disabled>اختر الاسم</option>

                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->supplier_code }}" @selected($supplier->supplier_code == $data->supplier_code)>
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
                                <option value="0" @selected($data->pill_type == '0')>كاش</option>
                                <option value="1" @selected($data->pill_type == '1')>اجل</option>
                            </select>
                            @error('pill_type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>رقم الفاتوره المسجل باصل فاتوره المشتريات</label> <br>
                            <input readonly name="doc_number" class="form-control" type="text" value="{{ $data->doc_number }}">
                            @error('doc_number')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>اختر المخزن </label>
                            <select id="store" name="store" class="form-control select2">
                                <option value="" selected disabled>اختر المخزن</option>

                                @if (isset($stores))
                                    @foreach ($stores as $store)
                                        <option value="{{ $store->id }}" @selected($data->store_id == $store->id)>
                                            {{ $store->name }}</option>
                                    @endforeach
                                @endif

                            </select>
                            @error('store')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="form-group row">


                            <div class="col-6">
                                <label>التاريخ </label> <br>
                                <input style="width: 550px; height: 40px" name="order_date" type="date"
                                    value="{{ $data->order_date }}">
                                @error('order_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="col-6">
                                <label>ملاحظات</label> <br>
                                <textarea name="notes" style="width: 550px">{{ $data->notes }}</textarea>
                                @error('notes')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                        </div>

                        <button type="submit" class="btn btn-primary m-2">
                            حفظ
                        </button>

                        <a href="{{ route('supplier_orders.show',$data->id) }}" class="btn btn-secondary">
                            رجوع
                        </a>

                    </form>

                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/admin/js/supplier_orders.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function() {
            $('.select2').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
@endsection
