@extends('layouts.admin')

@section('title')
    {{ __('generalReturnOrders.title') }}
@endsection

@section('contentheader')
    {{ __('generalReturnOrders.inventory_transactions') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('general_return_orders.index') }}">
        {{ __('generalReturnOrders.supplier_orders') }}
    </a>
@endsection

@section('contentheaderactive')
    {{ __('generalReturnOrders.show') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title card_title_center">
                        {{ __('generalReturnOrders.supplier_invoices') }}
                    </h3>

                    <a class="btn btn-success" href="{{ route('general_return_orders.create') }}">
                        {{ __('generalReturnOrders.add_new_invoice') }}
                    </a>
                </div>

                <div class="card-body">

                    @if (isset($data) && count($data) > 0)
                        <div id="ajax_responce_searchDiv">

                            <table class="table table-bordered table-hover text-center">
                                <thead class="custom_head">
                                    <tr>
                                        <th>{{ __('generalReturnOrders.invoice_code') }}</th>
                                        <th>{{ __('generalReturnOrders.supplier_name') }}</th>
                                        <th>{{ __('generalReturnOrders.invoice_type') }}</th>
                                        <th>{{ __('generalReturnOrders.store') }}</th>
                                        <th>{{ __('generalReturnOrders.invoice_date') }}</th>
                                        <th>{{ __('generalReturnOrders.approval_status') }}</th>
                                        <th>{{ __('generalReturnOrders.actions') }}</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $item->auto_serial }}</td>

                                            <td>{{ $item->supplier_name }}</td>

                                            <td>
                                                {{ __('generalReturnOrders.purchase_return_invoice') }}
                                            </td>

                                            <td>{{ $item->store_name }}</td>

                                            <td>{{ $item->order_date }}</td>

                                            <td>
                                                @if ($item->is_approved == 0)
                                                    <span class="badge badge-danger p-2">
                                                        {{ __('generalReturnOrders.not_approved') }}
                                                    </span>
                                                @else
                                                    <span class="badge badge-success p-2">
                                                        {{ __('generalReturnOrders.approved') }}
                                                    </span>
                                                @endif
                                            </td>

                                            <td>
                                                <a href="{{ route('general_return_orders.show', $item->id) }}"
                                                    class="btn btn-info">
                                                    {{ __('generalReturnOrders.details') }}
                                                </a>

                                                @if ($item->is_approved == 0)
                                                    <form action="{{ route('general_return_orders.destroy', $item->id) }}"
                                                        method="POST"
                                                        class="d-inline"
                                                        onsubmit="return confirm('{{ __('generalReturnOrders.confirm_delete') }}')">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="btn btn-danger">
                                                            {{ __('generalReturnOrders.delete') }}
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
                            {{ __('generalReturnOrders.no_data') }}
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/admin/js/ajax_search.js') }}"></script>
@endsection