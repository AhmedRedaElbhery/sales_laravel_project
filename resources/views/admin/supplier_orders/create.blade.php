@extends('layouts.admin')

@section('title')
    {{ __('suppliersOrders.purchases') }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('contentheader')
    {{ __('suppliersOrders.inventory_transactions') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('supplier_orders.index') }}">
        {{ __('suppliersOrders.purchase_invoice') }}
    </a>
@endsection

@section('contentheaderactive')
    {{ __('suppliersOrders.add') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                @if (session('success'))
                    <div class="alert alert-success text-center">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger text-center">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="card-header">
                    <h3 class="card-title card_title_center">
                        {{ __('suppliersOrders.add_new_invoice') }}
                    </h3>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger text-center">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('supplier_orders.store') }}" method="POST">
                        @csrf

                        <a href="{{ route('suppliers.create') }}" class="btn btn-primary text-white mb-2">
                            {{ __('suppliersOrders.add_new_supplier') }}
                        </a>

                        <div class="form-group">
                            <label>{{ __('suppliersOrders.supplier_name') }}</label><br>

                            <select name="supplier_code" class="form-control select2">
                                <option value="" selected disabled>
                                    {{ __('suppliersOrders.select_name') }}
                                </option>

                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->supplier_code }}"
                                        @selected(old('supplier_code') == $supplier->supplier_code)>
                                        {{ $supplier->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('supplier_code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ __('suppliersOrders.invoice_type') }}</label>

                            <select name="pill_type" class="form-control">
                                <option value="" selected disabled>
                                    {{ __('suppliersOrders.select_type') }}
                                </option>

                                <option value="0" @selected(old('pill_type') === '0')>
                                    {{ __('suppliersOrders.cash') }}
                                </option>

                                <option value="1" @selected(old('pill_type') === '1')>
                                    {{ __('suppliersOrders.credit') }}
                                </option>
                            </select>

                            @error('pill_type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ __('suppliersOrders.supplier_invoice_number') }}</label><br>

                            <input name="doc_number" class="form-control" type="text">

                            @error('doc_number')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ __('suppliersOrders.store') }}</label>

                            <select id="store" name="store" class="form-control select2">
                                <option value="" selected disabled>
                                    {{ __('suppliersOrders.select_store') }}
                                </option>

                                @if (isset($stores))
                                    @foreach ($stores as $store)
                                        <option value="{{ $store->id }}">
                                            {{ $store->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>

                            @error('store')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group row">

                            <div class="col-6">
                                <label>{{ __('suppliersOrders.date') }}</label><br>

                                <input style="width: 550px; height: 40px"
                                    name="order_date"
                                    type="date"
                                    value="@php echo date('Y-m-d') @endphp">

                                @error('order_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-6">
                                <label>{{ __('suppliersOrders.notes') }}</label><br>

                                <textarea name="notes" style="width: 550px"></textarea>

                                @error('notes')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary m-2">
                            {{ __('suppliersOrders.save') }}
                        </button>

                        <a href="{{ route('supplier_orders.index') }}" class="btn btn-secondary">
                            {{ __('suppliersOrders.back') }}
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