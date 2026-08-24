@extends('layouts.admin');

@section('title')
{{ __('supplierAccounts.page_title') }}
@endsection

@section('contentheader')
{{ __('supplierAccounts.page_title') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('customers.index') }}"> {{ __('supplierAccounts.page_title') }} </a>
@endsection


@section('contentheaderactive')
{{ __('supplierAccounts.view') }}
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
                    <h3 class="card-title card_title_center">{{ __('supplierAccounts.page_title') }} </h3>
                    <a class="btn btn-success" href="{{ route('suppliers.create') }}">{{ __('supplierAccounts.add_new') }}</a>
                </div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" id="search_by_name" placeholder="{{ __('supplierAccounts.search_by_name') }}" class="form-control mb-3">
                        </div>


                    </div>

                    @if (isset($data) && count($data) > 0)
                        <div id="ajax_responce_searchDiv">

                            <table class="table table-bordered table-hover text-center">
                                <thead class="custom_head">
                                    <tr>
                                        <th>{{ __('supplierAccounts.name') }}</th>
                                        <th>{{ __('supplierAccounts.supplier_code') }}</th>
                                        <th>{{ __('supplierAccounts.account_number') }} </th>
                                        <th>{{ __('supplierAccounts.supplier_category') }} </th>
                                        <th>{{ __('supplierAccounts.current_balance') }} </th>
                                        <th>{{ __('supplierAccounts.status') }}</th>
                                        <th> </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->supplier_code }}</td>

                                            <td>{{ $item->account_number }}</td>
                                            <td>{{ $item->supplier_category_name }}</td>

                                            <td>{{ $item->current_balance /100 }}</td>

                                            <td>
                                                @if ($item->active == 1)
                                                    <span class="badge badge-success p-2">{{ __('supplierAccounts.active') }}</span>
                                                @else
                                                    <span class="badge badge-danger p-2">{{ __('supplierAccounts.inactive') }}</span>
                                                @endif
                                            </td>

                                            <td>
                                                <a href="{{ route('suppliers.edit', $item->id) }}"
                                                    class="btn btn-primary">{{ __('supplierAccounts.edit') }}</a>

                                                <form action="{{ route('suppliers.destroy', $item->id) }}" method="POST"
                                                    class="d-inline" onsubmit="return confirm('{{ __('supplierAccounts.confirm_delete') }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">{{ __('supplierAccounts.delete') }}</button>
                                                </form>
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
                            لا توجد بيانات
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
