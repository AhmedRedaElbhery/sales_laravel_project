@extends('layouts.admin');

@section('title')
    {{ __('accounts.title') }}
@endsection

@section('contentheader')
{{ __('accounts.financial_accounts') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('accounts.index') }}"> {{ __('accounts.financial_accounts') }} </a>
@endsection


@section('contentheaderactive')
{{ __('accounts.show') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title card_title_center">{{ __('accounts.financial_accounts') }}  </h3>
                    <a class="btn btn-success" href="{{ route('accounts.create') }}">{{ __('accounts.add_new') }} </a>
                </div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" id="search_by_name" placeholder="{{ __('accounts.search_by_name') }} " class="form-control mb-3">
                        </div>

                        <div class="col-md-4">
                            <form action="{{ route('accounts.filter') }}" method="POST">
                                @csrf
                                <select name="type" class="form-control" onchange="this.form.submit()">
                                    @if (!isset($parentOrNo))
                                        <option value="all">{{ __('accounts.show_all') }} </option>
                                        <option value="1">{{ __('accounts.parent_accounts') }} </option>
                                        <option value="0">{{ __('accounts.child_accounts') }} </option>
                                    @else
                                        @if ($parentOrNo == 0)
                                            <option value="all">{{ __('accounts.show_all') }} </option>
                                            <option value="1">{{ __('accounts.parent_accounts') }} </option>
                                            <option value="0" selected>{{ __('accounts.child_accounts') }} </option>
                                        @elseif($parentOrNo == 1)
                                            <option value="all">{{ __('accounts.show_all') }}</option>
                                            <option value="1" selected>{{ __('accounts.parent_accounts') }}</option>
                                            <option value="0">{{ __('accounts.child_accounts') }}</option>
                                        @else
                                            <option value="all" selected>{{ __('accounts.show_all') }}</option>
                                            <option value="1">{{ __('accounts.parent_accounts') }}</option>
                                            <option value="0">{{ __('accounts.child_accounts') }}</option>
                                        @endif
                                    @endif
                                </select>
                            </form>
                        </div>
                    </div>

                    @if (isset($data) && count($data) > 0)
                        <div id="ajax_responce_searchDiv">

                            <table class="table table-bordered table-hover text-center">
                                <thead class="custom_head">
                                    <tr>
                                        <th>{{ __('accounts.name') }}</th>
                                        <th>{{ __('accounts.account_number') }} </th>
                                        <th>{{ __('accounts.account_type') }}</th>
                                        <th>{{ __('accounts.is_parent') }} </th>
                                        <th>{{ __('accounts.parent_account') }}</th>
                                        <th>{{ __('accounts.current_balance') }} </th>
                                        <th>{{ __('accounts.status') }}</th>
                                        <th> </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->account_number }}</td>
                                            <td>
                                                {{ $item->type }}
                                            </td>

                                            <td>
                                                @if ($item->is_parent == 1)
                                                    <span class="badge badge-success p-2">{{ __('accounts.yes') }}</span>
                                                @else
                                                    <span class="badge badge-danger p-2">{{ __('accounts.no') }}</span>
                                                @endif
                                            </td>

                                            <td>
                                                {{ $item->parent_account_name }}

                                            </td>

                                            <td>{{ $item->current_balance / 100 }}</td>

                                            <td>
                                                @if ($item->is_archived == 0)
                                                    <span class="badge badge-success p-2">{{ __('accounts.active') }}</span>
                                                @else
                                                    <span class="badge badge-danger p-2">{{ __('accounts.inactive') }}</span>
                                                @endif
                                            </td>

                                            <td>
                                                <a href="{{ route('accounts.edit', $item->id) }}"
                                                    class="btn btn-primary">{{ __('accounts.edit') }}</a>

                                                <form action="{{ route('accounts.destroy', $item->id) }}" method="POST"
                                                    class="d-inline" onsubmit="return confirm('{{ __('accounts.confirm_delete') }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">{{ __('accounts.delete') }}</button>
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
                            {{ __('accounts.no_data') }}
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
