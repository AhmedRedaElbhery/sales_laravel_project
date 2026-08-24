@extends('layouts.admin');

@section('title')
{{ __('treasuries.title') }}
@endsection

@section('contentheader')
{{ __('treasuries.title') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin.treasuries.index') }}"> {{ __('treasuries.title') }} </a>
@endsection


@section('contentheaderactive')
    عرض
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
                    <h3 class="card-title card_title_center">{{ __('treasuries.treasuries_data') }}</h3>
                </div>

                <div class="card-body">
                    <a class="btn btn-success m-2" href="{{ route('admin.treasuries.create') }}">{{ __('treasuries.add_new') }}</a>


                    <div class="col-md-4">
                        <input type="text" id="search_by_name" placeholder="{{ __('treasuries.search_by_name') }}" class=" form-control mb-3">
                    </div>
                    @if (isset($data) && count($data) > 0)
                        <div id="ajax_responce_searchDiv">

                            <table class="table table-bordered table-hover text-center">
                                <thead class="custom_head">
                                    <tr>
                                        <th>{{ __('treasuries.serial') }}</th>
                                        <th>{{ __('treasuries.treasury_name') }}</th>
                                        <th>{{ __('treasuries.is_master') }}</th>
                                        <th>{{ __('treasuries.status') }}</th>
                                        <th>{{ __('treasuries.company_code') }}</th>
                                        <th>{{ __('treasuries.last_exchange_receipt') }}</th>
                                        <th>{{ __('treasuries.last_collect_receipt') }}</th>
                                        <th> </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>

                                            <td>{{ $item->name }}</td>

                                            <td>
                                                @if ($item->is_master == 1)
                                                {{ __('treasuries.master') }}
                                                @else
                                                {{ __('treasuries.branch') }}
                                                @endif
                                            </td>

                                            <td>
                                                @if ($item->active == 1)
                                                    <span class="badge badge-success">{{ __('treasuries.active') }}</span>
                                                @else
                                                    <span class="badge badge-danger">{{ __('treasuries.inactive') }}</span>
                                                @endif
                                            </td>

                                            <td>{{ $item->com_code }}</td>
                                            <td>{{ $item->last_isal_exchange }}</td>
                                            <td>{{ $item->last_isal_collect }}</td>

                                            <td>
                                                <a href="{{ route('admin.treasuries.edit', $item->id) }}"
                                                    class="btn btn-primary">{{ __('treasuries.edit') }}</a>
                                                <a href="{{ route('admin.treasuries.details', $item->id) }}" class="btn btn-info">{{ __('treasuries.details') }}</a>

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
                            {{ __('treasuries.no_data') }}
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
