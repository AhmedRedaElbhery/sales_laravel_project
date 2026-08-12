@extends('layouts.admin');

@section('title')
{{ __('delegates.page_title') }}
@endsection

@section('contentheader')
{{ __('delegates.accounts') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('customers.index') }}"> {{ __('delegates.page_title') }} </a>
@endsection


@section('contentheaderactive')
{{ __('delegates.view') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title card_title_center">{{ __('delegates.page_title') }} </h3>
                    <a class="btn btn-success" href="{{ route('delegate.create') }}">{{ __('delegates.add_new') }}</a>
                </div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" id="search_by_name" placeholder="{{ __('delegates.search_by_name') }}" class="form-control mb-3">
                        </div>


                    </div>

                    @if (isset($data) && count($data) > 0)
                        <div id="ajax_responce_searchDiv">

                            <table class="table table-bordered table-hover text-center">
                                <thead class="custom_head">
                                    <tr>
                                        <th>{{ __('delegates.name') }}</th>
                                        <th>{{ __('delegates.delegate_code') }}</th>
                                        <th>{{ __('delegates.account_number') }} </th>
                                        <th>{{ __('delegates.current_balance') }} </th>
                                        <th>{{ __('delegates.status') }}</th>
                                        <th> </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->delegate_code }}</td>

                                            <td>{{ $item->account_number }}</td>

                                            <td>{{ $item->current_balance /100 }}</td>

                                            <td>
                                                @if ($item->active == 1)
                                                    <span class="badge badge-success p-2">{{ __('delegates.active') }}</span>
                                                @else
                                                    <span class="badge badge-danger p-2">{{ __('delegates.inactive') }}</span>
                                                @endif
                                            </td>

                                            <td>
                                                <a href="{{ route('delegate.edit', $item->id) }}"
                                                    class="btn btn-primary">{{ __('delegates.edit') }}</a>

                                                <form action="{{ route('delegate.destroy', $item->id) }}" method="POST"
                                                    class="d-inline" onsubmit="return confirm('{{ __('delegates.confirm_delete') }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">{{ __('delegates.delete') }}</button>
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
                            {{ __('delegates.no_data') }}
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
