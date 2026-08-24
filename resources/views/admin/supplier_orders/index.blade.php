@extends('layouts.admin')

@section('title')
    {{ __('suppliersOrders.title') }}
@endsection

@section('contentheader')
    {{ __('suppliersOrders.inventory_transactions') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('supplier_orders.index') }}">
        {{ __('suppliersOrders.supplier_orders') }}
    </a>
@endsection

@section('contentheaderactive')
    {{ __('suppliersOrders.show') }}
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
                        {{ __('suppliersOrders.supplier_invoices') }}
                    </h3>

                    <a class="btn btn-success" href="{{ route('supplier_orders.create') }}">
                        {{ __('suppliersOrders.add_new_invoice') }}
                    </a>
                </div>
                @if ($exist)

                <div class="card-body">

                    @if (isset($data) && count($data) > 0)
                        <div id="ajax_responce_searchDiv">

                            <table class="table table-bordered table-hover text-center">
                                <thead class="custom_head">
                                    <tr>
                                        <th>{{ __('suppliersOrders.invoice_code') }}</th>
                                        <th>{{ __('suppliersOrders.supplier_name') }}</th>
                                        <th>{{ __('suppliersOrders.invoice_type') }}</th>
                                        <th>{{ __('suppliersOrders.store') }}</th>
                                        <th>{{ __('suppliersOrders.invoice_date') }}</th>
                                        <th>{{ __('suppliersOrders.approval_status') }}</th>
                                        <th>{{ __('suppliersOrders.actions') }}</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $item->auto_serial }}</td>

                                            <td>{{ $item->supplier_name }}</td>

                                            <td>
                                                @if ($item->doc_type == 1)
                                                    {{ __('suppliersOrders.purchase_invoice') }}
                                                @elseif ($item->doc_type == 2)
                                                    {{ __('suppliersOrders.purchase_return_invoice') }}
                                                @else
                                                    {{ __('suppliersOrders.purchase_invoice') }}
                                                @endif
                                            </td>

                                            <td>{{ $item->store_name }}</td>

                                            <td>{{ $item->order_date }}</td>

                                            <td>
                                                @if ($item->is_approved == 0)
                                                    <span class="badge badge-danger p-2">
                                                        {{ __('suppliersOrders.not_approved') }}
                                                    </span>
                                                @else
                                                    <span class="badge badge-success p-2">
                                                        {{ __('suppliersOrders.approved') }}
                                                    </span>
                                                @endif
                                            </td>

                                            <td>
                                                <a href="{{ route('supplier_orders.show', $item->id) }}"
                                                    class="btn btn-info">
                                                    {{ __('suppliersOrders.details') }}
                                                </a>

                                                @if ($item->is_approved == 0)
                                                    <form action="{{ route('supplier_orders.destroy', $item->id) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('{{ __('suppliersOrders.confirm_delete') }}')">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="btn btn-danger">
                                                            {{ __('suppliersOrders.delete') }}
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <br>

                            <div class="mt-3">
                                {{ $data->links() }}
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            {{ __('suppliersOrders.no_data') }}
                        </div>
                    @endif

                </div>
                @else
                <div class="alert alert-danger">
                    {{ __('suppliersOrders.no_shift') }}
                </div>

                @endif

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/admin/js/ajax_search.js') }}"></script>
@endsection
