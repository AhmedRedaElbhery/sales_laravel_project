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
                    <h3 class="card-title card_title_center">
                        {{ __('admin_accounts.users_data') }}
                    </h3>

                    <a class="btn btn-success" href="{{ route('admin_accounts.create') }}">
                        {{ __('admin_accounts.add_new') }}
                    </a>
                </div>

                <div class="card-body">

                    @if (isset($data) && count($data) > 0)
                        <div id="ajax_responce_searchDiv">

                            <table class="table table-bordered table-hover text-center">
                                <thead class="custom_head">
                                    <tr>
                                        <th>{{ __('admin_accounts.serial') }}</th>
                                        <th>{{ __('admin_accounts.user_name') }}</th>
                                        <th>{{ __('admin_accounts.email') }}</th>
                                        <th>{{ __('admin_accounts.created_at') }}</th>
                                        <th>{{ __('admin_accounts.actions') }}</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>

                                            <td>{{ $item->name }}</td>

                                            <td>{{ $item->email }}</td>

                                            <td>
                                                @if ($item['created_at'] != null)
                                                    {{ $item['created_at']->format('Y-m-d h:i') . ' ' . ($item['created_at']->format('A') == 'AM' ? __('admin_accounts.am') : __('admin_accounts.pm')) }}
                                                    {{ __('admin_accounts.added_by') }}<br>
                                                    {{ $item['added_by_admin'] }}
                                                @else
                                                    {{ __('admin_accounts.no_data') }}
                                                @endif
                                            </td>

                                            <td>
                                                <a href="{{ route('admin_accounts.edit', $item->id) }}"
                                                    class="btn btn-primary">
                                                    {{ __('admin_accounts.edit') }}
                                                </a>

                                                <a href="{{ route('admin_accounts.show', $item->id) }}"
                                                    class="btn btn-info">
                                                    {{ __('admin_accounts.show') }}
                                                </a>

                                                <form action="{{ route('admin_accounts.destroy', $item->id) }}"
                                                    method="POST"
                                                    class="d-inline"
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

                            <br>

                            <div class="mt-3">
                                {{ $data->links() }}
                            </div>

                        </div>
                    @else
                        <div class="alert alert-warning">
                            {{ __('admin_accounts.no_records') }}
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