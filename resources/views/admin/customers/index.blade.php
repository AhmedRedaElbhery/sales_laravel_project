@extends('layouts.admin');

@section('title')
{{ __('customers.page_title') }}
@endsection

@section('contentheader')
{{ __('customers.accounts') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('customers.index') }}"> {{ __('customers.page_title') }} </a>
@endsection


@section('contentheaderactive')
{{ __('customers.view') }}
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
                    <h3 class="card-title card_title_center">{{ __('customers.page_title') }} </h3>
                    <a class="btn btn-success" href="{{ route('customers.create') }}">{{ __('customers.add_new') }}</a>
                </div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" id="search_by_name" placeholder="{{ __('customers.search_by_name') }}" class="form-control mb-3">
                        </div>


                    </div>

                    @if (isset($data) && count($data) > 0)
                        <div id="ajax_responce_searchDiv">

                            <table class="table table-bordered table-hover text-center">
                                <thead class="custom_head">
                                    <tr>
                                        <th>{{ __('customers.name') }}</th>
                                        <th>{{ __('customers.customer_code') }}</th>
                                        <th>{{ __('customers.account_number') }} </th>
                                        <th>{{ __('customers.current_balance') }} </th>
                                        <th>{{ __('customers.status') }}</th>
                                        <th> </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->customer_code }}</td>

                                            <td>{{ $item->account_number }}</td>

                                            <td>{{ $item->current_balance /100 }}</td>

                                            <td>
                                                @if ($item->active == 1)
                                                    <span class="badge badge-success">{{ __('customers.active') }}</span>
                                                @else
                                                    <span class="badge badge-danger">{{ __('customers.inactive') }}</span>
                                                @endif
                                            </td>

                                            <td>
                                                <a href="{{ route('customers.edit', $item->id) }}"
                                                    class="btn btn-primary">{{ __('customers.edit') }}</a>

                                                <form action="{{ route('customers.destroy', $item->id) }}" method="POST"
                                                    class="d-inline" onsubmit="return confirm('{{ __('customers.confirm_delete') }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">{{ __('customers.delete') }}</button>
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
                            {{ __('customers.no_data') }}
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
