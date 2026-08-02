@extends('layouts.admin')

@section('title')
   {{ __('admin_accounts.title') }}
@endsection

@section('contentheader')
   {{ __('admin_accounts.content_header') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin_accounts.index') }}">
       {{ __('admin_accounts.content_header_link') }}
    </a>
@endsection

@section('contentheaderactive')
   {{ __('admin_accounts.content_header_active') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title card_title_center">{{ __('admin_accounts.user_data') }}</h3>
                </div>

                <div class="card-body">
                    @if (isset($data))
                        <table id="example2" class="table table-bordered table-hover">
                            <tr>
                                <td class="width30">{{ __('admin_accounts.user_name') }}</td>
                                <td>{{ $data['name'] }}</td>
                            </tr>

                            <tr>
                                <td>{{ __('admin_accounts.created_at') }}</td>
                                <td>
                                    @if ($data['added_by'] > 0 && $data['added_by'] != null)
                                        @php
                                            $dt = new DateTime($data['created_at']);
                                            $date = $dt->format('Y-m-d');
                                            $time = $dt->format('h-i');
                                            $newdatetime = date('A', strtotime($time));
                                            $newdatetimetype =
                                                $newdatetime == 'AM'
                                                    ? __('admin_accounts.am')
                                                    : __('admin_accounts.pm');
                                        @endphp

                                        {{ $date }}
                                        {{ $time }}
                                        {{ $newdatetimetype }}
                                        {{ __('admin_accounts.added_by') }}
                                        {{ $data['added_by_admin'] }}
                                    @else
                                        {{ __('admin_accounts.no_data') }}
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td>{{ __('admin_accounts.updated_at') }}</td>
                                <td>
                                    @if ($data['updated_by'] > 0 && $data['updated_by'] != null)
                                        @php
                                            $dt = new DateTime($data['updated_at']);
                                            $date = $dt->format('Y-m-d');
                                            $time = $dt->format('h-i');
                                            $newdatetime = date('A', strtotime($time));
                                            $newdatetimetype =
                                                $newdatetime == 'PM'
                                                    ? __('admin_accounts.am')
                                                    : __('admin_accounts.pm');
                                        @endphp

                                        {{ $date }}
                                        {{ $time }}
                                        {{ $newdatetimetype }}
                                        {{ __('admin_accounts.updated_by') }}
                                        {{ $data['updated_by_admin'] }}
                                    @else
                                        {{ __('admin_accounts.no_data') }}
                                    @endif

                                    <a href="{{ route('admin.treasuries.edit', $data->id) }}"
                                        class="btn btn-primary">
                                        {{ __('admin_accounts.edit') }}
                                    </a>
                                </td>
                            </tr>

                        </table>
                        <br>
                    @else
                        <div class="alert alert-warning">
                            {{ __('admin_accounts.no_records') }}
                        </div>
                    @endif

                    <div class="card-header">
                        <h3 class="card-title card_title_center">
                            {{ __('admin_accounts.user_treasuries') }}
                            ({{ $data['name'] }})
                        </h3>
                    </div>

                    <button type="button" class="btn btn-primary m-2 addtreasuries"
                        data-toggle="modal" data-target="#addtreasuries">
                        {{ __('admin_accounts.add_new_treasury') }}
                    </button>

                    @if (isset($admin_treasuries) && count($admin_treasuries) > 0)
                        <table class="table table-bordered table-hover text-center">
                            <thead class="custom_head">
                                <tr>
                                    <th>{{ __('admin_accounts.serial') }}</th>
                                    <th>{{ __('admin_accounts.treasury_name') }}</th>
                                    <th>{{ __('admin_accounts.created_at') }}</th>
                                    <th>{{ __('admin_accounts.actions') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($admin_treasuries as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>

                                        <td>{{ $item->name }}</td>

                                        <td>
                                            @if ($item['created_at'] != null)
                                                @php
                                                    $dt = new DateTime($item['created_at']);
                                                    $date = $dt->format('Y-m-d');
                                                    $time = $dt->format('h-i');
                                                    $newdatetime = date('A', strtotime($time));
                                                    $newdatetimetype =
                                                        $newdatetime == 'PM'
                                                            ? __('admin_accounts.am')
                                                            : __('admin_accounts.pm');
                                                @endphp

                                                {{ $date }}
                                                {{ $time }}
                                                {{ $newdatetimetype }}
                                                {{ __('admin_accounts.added_by') }}
                                                {{ $data['added_by_admin'] }}
                                            @else
                                                {{ __('admin_accounts.no_data') }}
                                            @endif
                                        </td>

                                        <td>
                                            <form action="{{ route('admin_treasuries.deletetreasuries', $item->id) }}"
                                                method="POST"
                                                style="display:inline;"
                                                onsubmit="return confirm('{{ __('admin_accounts.confirm_delete') }}')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger">
                                                    {{ __('admin_accounts.delete') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-warning">
                            {{ __('admin_accounts.no_records') }}
                        </div>
                    @endif

                </div>

            </div>

            <div class="modal fade" id="addtreasuries">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content bg-info">
                        <div class="modal-header">
                            <h4 class="modal-title">{{ __('admin_accounts.treasuries') }}</h4>
                            <button type="button" class="close color-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <input type="hidden" id="token_search" value="{{ csrf_token() }}">
                        <input type="hidden" id="admin_id" value="{{ $data->id }}">
                        <input type="hidden" id="ajax_addtreasuries" value="{{ route('admin_treasuries.addtreasuries') }}">
                        <input type="hidden" id="ajax_edititem" value="{{ route('supplier_orders.edititem') }}">

                        <div class="modal-body" id="edit_item_model_body"
                            style="background-color: white !important; color: black;">

                            <div class="col-4">
                                <label for="admin_id">{{ __('admin_accounts.treasury_name') }}</label>

                                <select name="name" id="name" class="form-control">
                                    <option selected disabled value="">
                                        {{ __('admin_accounts.select_treasury') }}
                                    </option>

                                    @foreach ($treasuries as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="m-2 text-center">
                                <button type="button" class="btn btn-info" id="add">
                                    {{ __('admin_accounts.add') }}
                                </button>
                            </div>

                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-outline-light" data-dismiss="modal">
                                {{ __('admin_accounts.close') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/admin/js/admin_treasuries.js') }}"></script>
@endsection
