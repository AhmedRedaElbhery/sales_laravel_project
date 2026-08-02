@extends('layouts.admin');

@section('title')
{{ __('salesCategories.page_title') }}
@endsection

@section('contentheader')
{{ __('salesCategories.page_title') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin.sales_material.index') }}"> {{ __('salesCategories.page_title') }} </a>
@endsection


@section('contentheaderactive')
{{ __('salesCategories.view') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title card_title_center">{{ __('salesCategories.invoice_categories_data') }}</h3>
                    <a class="btn btn-success" href="{{ route('admin.sales_material.create') }}">{{ __('salesCategories.add_new') }}</a>
                </div>

                <div class="card-body">

                    @if (isset($data) && count($data) > 0)
                        <div id="ajax_responce_searchDiv">

                            <table class="table table-bordered table-hover text-center">
                                <thead class="custom_head">
                                    <tr>
                                        <th>{{ __('salesCategories.serial') }}</th>
                                        <th>{{ __('salesCategories.category_name') }}</th>
                                        <th>{{ __('salesCategories.status') }}</th>
                                        <th>{{ __('salesCategories.created_at') }}</th>
                                        <th>{{ __('salesCategories.updated_at') }}</th>
                                        <th> </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>

                                            <td>{{ $item->name }}</td>

                                            <td>
                                                @if ($item->active == 1)
                                                    <span class="badge badge-success">{{ __('salesCategories.active') }}</span>
                                                @else
                                                    <span class="badge badge-danger">{{ __('salesCategories.inactive') }}</span>
                                                @endif
                                            </td>

                                            <td>
                                                @if ($item['created_at'] != null)
                                                {{ $item['created_at']->format('Y-m-d h:i') . ' ' . ($item['created_at']->format('A') == 'AM' ?  __('salesCategories.am'):  __('salesCategories.pm')) }}
                                                {{ __('salesCategories.by') }}
                                                    {{ $item['added_by_admin'] }}
                                                @else
                                                    {{ __('salesCategories.none') }}
                                                @endif

                                            </td>

                                            <td>
                                                @if ($item['updated_by'] > 0 && $item['updated_at'] != null)
                                                {{ $item['updated_at']->format('Y-m-d h:i') . ' ' . ($item['updated_at']->format('A') == 'AM' ?  __('salesCategories.am') :  __('salesCategories.pm')) }}
                                                {{ __('salesCategories.by') }}
                                                    {{ $item['updated_by_admin'] }}
                                                @else
                                                {{ __('salesCategories.none') }}
                                                @endif
                                            </td>


                                            <td>
                                                <a href="{{ route('admin.sales_material.edit', $item->id) }}"
                                                    class="btn btn-primary"> {{ __('salesCategories.edit') }}</a>

                                                <form action="{{ route('admin.sales_material.delete', $item->id) }}"
                                                    method="POST"
                                                    class="d-inline" onsubmit="return confirm(' {{ __('salesCategories.confirm_delete') }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"> {{ __('salesCategories.delete') }}</button>
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
                            {{ __('salesCategories.no_data') }}
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
