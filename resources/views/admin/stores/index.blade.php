@extends('layouts.admin');

@section('title')
{{ __('stores.title') }}
@endsection

@section('contentheader')
{{ __('stores.title') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin.store.index') }}"> {{ __('stores.title') }} </a>
@endsection


@section('contentheaderactive')
{{ __('stores.show') }}
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
                    <h3 class="card-title card_title_center">{{ __('stores.stores_data') }} </h3>
                    <a class="btn btn-success" href="{{ route('admin.store.create') }}">{{ __('stores.add_new') }}</a>
                </div>

                <div class="card-body">

                    @if (isset($data) && count($data) > 0)
                        <div id="ajax_responce_searchDiv">

                            <table class="table table-bordered table-hover text-center">
                                <thead class="custom_head">
                                    <tr>
                                        <th>{{ __('stores.sequence') }}</th>
                                        <th>{{ __('stores.store_name') }}</th>
                                        <th>{{ __('stores.phone') }}</th>
                                        <th>{{ __('stores.address') }}</th>
                                        <th>{{ __('stores.active_status') }}</th>
                                        <th>{{ __('stores.created_at') }}</th>
                                        <th>{{ __('stores.updated_at') }}</th>
                                        <th> </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>

                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->phone }}</td>
                                            <td>{{ $item->address }}</td>

                                            <td>
                                                @if ($item->active == 1)
                                                    <span class="badge badge-success">{{ __('stores.active') }}</span>
                                                @else
                                                    <span class="badge badge-danger">{{ __('stores.inactive') }}</span>
                                                @endif
                                            </td>

                                            <td>
                                                @if ($item['created_at'] != null)
                                                {{ $item['created_at']->format('Y-m-d h:i') . ' ' . ($item['created_at']->format('A') == 'AM' ? __('stores.am') :  __('stores.pm') ) }}
                                                {{ __('stores.by') }}<br>
                                                    {{ $item['added_by_admin'] }}
                                                @else
                                                {{ __('stores.no_data') }}
                                                @endif

                                            </td>

                                            <td>
                                                @if ($item['updated_by'] > 0 && $item['updated_at'] != null)
                                                {{ $item['updated_at']->format('Y-m-d h:i') . ' ' . ($item['updated_at']->format('A') == 'AM' ? __('stores.am') : __('stores.pm')) }}
                                                {{ __('stores.by') }}<br>
                                                    {{ $item['updated_by_admin'] }}
                                                @else
                                                {{ __('stores.no_data') }}
                                                @endif
                                            </td>


                                            <td>
                                                <a href="{{ route('admin.store.edit', $item->id) }}"
                                                    class="btn btn-primary">{{ __('stores.edit') }}</a>

                                                <form action="{{ route('admin.store.delete', $item->id) }}"
                                                    method="POST"
                                                    class="d-inline" onsubmit="return confirm('{{ __('stores.confirm_delete') }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">{{ __('stores.delete') }}</button>
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

                            {{ __('stores.no_data') }}
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
