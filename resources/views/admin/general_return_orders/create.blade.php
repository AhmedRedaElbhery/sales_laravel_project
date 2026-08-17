@extends('layouts.admin')

@section('title')
   {{ __('generalReturnOrders.title') }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('contentheader')
   {{ __('generalReturnOrders.inventory_transactions') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('general_return_orders.index') }}">
       {{ __('generalReturnOrders.supplier_invoices') }}
    </a>
@endsection

@section('contentheaderactive')
   {{ __('generalReturnOrders.add') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title card_title_center">
                       {{ __('generalReturnOrders.add_new_invoice') }}
                    </h3>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger text-center">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('general_return_orders.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>{{ __('suppliersOrders.supplier_name') }}</label><br>

                            <select name="supplier_code" class="form-control select2">
                                <option value="" selected disabled>
                                   {{ __('generalReturnOrders.select_name') }}
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
                                   {{ __('generalReturnOrders.select_type') }}
                                </option>

                                <option value="0" @selected(old('pill_type') === '0')>
                                   {{ __('generalReturnOrders.cash') }}
                                </option>

                                <option value="1" @selected(old('pill_type') === '1')>
                                   {{ __('generalReturnOrders.credit') }}
                                </option>
                            </select>

                            @error('pill_type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ __('suppliersOrders.store') }}</label>

                            <select id="store" name="store" class="form-control select2">
                                <option value="" selected disabled>
                                   {{ __('generalReturnOrders.select_store') }}
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
                           {{ __('generalReturnOrders.save') }}
                        </button>

                        <a href="{{ route('general_return_orders.index') }}" class="btn btn-secondary">
                           {{ __('generalReturnOrders.back') }}
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