@extends('layouts.admin');

@section('title')
{{ __('units.title') }}
@endsection

@section('contentheader')
{{ __('units.title') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('unit.index') }}">  {{ __('units.title') }} </a>
@endsection


@section('contentheaderactive')
{{ __('units.show') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title card_title_center">{{ __('units.units_data') }} </h3>
                    <a class="btn btn-success" href="{{ route('unit.create') }}">{{ __('units.add_new_unit') }}</a>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" id="search_by_name" placeholder="{{ __('units.search_by_name') }}" class="form-control mb-3">
                        </div>

                        <div class="col-md-4">
                            <form action="{{ route('unit.filter') }}" method="POST">
                                @csrf
                                <select name="type" class="form-control" onchange="this.form.submit()">
                                    @if (!isset($parentOrNo))
                                        <option value="all">{{ __('units.show_all') }}</option>
                                        <option value="1">{{ __('units.master_units') }}</option>
                                        <option value="0">{{ __('units.sub_units') }}</option>
                                    @else
                                        @if ($parentOrNo == 0)
                                            <option value="all" >{{ __('units.show_all') }}</option>
                                            <option value="1">{{ __('units.master_units') }}</option>
                                            <option value="0" selected>{{ __('units.sub_units') }}</option>
                                        @elseif($parentOrNo == 1)
                                            <option value="all">{{ __('units.show_all') }}</option>
                                            <option value="1" selected>{{ __('units.master_units') }}</option>
                                            <option value="0">{{ __('units.sub_units') }}</option>
                                        @else
                                            <option value="all" selected>{{ __('units.show_all') }}</option>
                                            <option value="1">{{ __('units.master_units') }}</option>
                                            <option value="0" >{{ __('units.sub_units') }}</option>
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
                                        <th>{{ __('units.serial') }}</th>
                                        <th>{{ __('units.unit_name') }}</th>
                                        <th>{{ __('units.is_master') }}</th>
                                        <th>{{ __('units.status') }}</th>
                                        <th>{{ __('units.created_at') }}</th>
                                        <th>{{ __('units.updated_at') }}</th>
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
                                                {{ __('units.master_unit') }}
                                                @else
                                                {{ __('units.sub_unit') }}
                                                @endif
                                            </td>

                                            <td>
                                                @if ($item->active == 1)
                                                    <span class="badge badge-success">{{ __('units.active') }}</span>
                                                @else
                                                    <span class="badge badge-danger">{{ __('units.inactive') }}</span>
                                                @endif
                                            </td>

                                            <td>
                                                @if ($item['created_at'] != null)
                                                    {{ $item['created_at']->format('Y-m-d h:i') . ' ' . ($item['created_at']->format('A') == 'AM' ?  __('units.am')  : __('units.pm')) }}
                                                    {{ __('units.by') }}
                                                    {{ $item['added_by_admin'] }}
                                                @else
                                                {{ __('units.not_fount') }}
                                                @endif

                                            </td>

                                            <td>
                                                @if ($item['updated_by'] > 0 && $item['updated_at'] != null)
                                                    {{ $item['updated_at']->format('Y-m-d h:i') . ' ' . ($item['updated_at']->format('A') == 'AM' ? __('units.am'): __('units.pm')) }}
                                                    {{ __('units.by') }}
                                                    {{ $item['updated_by_admin'] }}
                                                @else
                                                {{ __('units.not_found') }}
                                                @endif
                                            </td>


                                            <td>
                                                <a href="{{ route('unit.edit', $item->id) }}"
                                                    class="btn btn-primary">{{ __('units.edit') }}</a>

                                                <form action="{{ route('unit.destroy', $item->id) }}" method="POST"
                                                    class="d-inline" onsubmit="return confirm('{{ __('units.confirm_delete') }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">{{ __('units.delete') }}</button>
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
                            {{ __('units.no_data') }}
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
