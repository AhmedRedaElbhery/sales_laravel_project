@extends('layouts.admin')

@section('title')
    {{ __('account_types.accounts') }}
@endsection

@section('contentheader')
    {{ __('account_types.account_types') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin.accounttypes.index') }}">
        {{ __('account_types.account_types') }}
    </a>
@endsection

@section('contentheaderactive')
    {{ __('account_types.show') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title card_title_center">
                        {{ __('account_types.account_types') }}
                    </h3>
                </div>

                <div class="card-body">

                    @if (isset($data) && count($data) > 0)
                        <div>

                            <table class="table table-bordered table-hover text-center">
                                <thead class="custom_head">
                                    <tr>
                                        <th>{{ __('account_types.serial') }}</th>
                                        <th>{{ __('account_types.account_name') }}</th>
                                        <th>{{ __('account_types.status') }}</th>
                                        <th>{{ __('account_types.can_be_added_from_internal_screen') }}</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>

                                            <td>{{ $item->name }}</td>

                                            <td>
                                                @if ($item->active == 1)
                                                    <span class="badge badge-success p-2">
                                                        {{ __('account_types.active') }}
                                                    </span>
                                                @else
                                                    <span class="badge badge-danger p-2">
                                                        {{ __('account_types.inactive') }}
                                                    </span>
                                                @endif
                                            </td>

                                            <td>
                                                @if ($item->relatedinternalaccounts == 1)
                                                    <span class="badge badge-success p-2">
                                                        {{ __('account_types.yes_can_be_added') }}
                                                    </span>
                                                @else
                                                    <span class="badge badge-danger p-2">
                                                        {{ __('account_types.no_is_main') }}
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <br>

                        </div>
                    @else
                        <div class="alert alert-warning">
                            {{ __('account_types.no_data') }}
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </div>
@endsection
