@extends('layouts.admin');

@section('title')
    {{ __('supplierCategory.page_title') }}
@endsection

@section('contentheader')
    {{ __('supplierCategory.page_title') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('suppliers_category.index') }}"> {{ __('supplierCategory.page_title') }} </a>
@endsection


@section('contentheaderactive')
    {{ __('supplierCategory.view') }}
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
                    <h3 class="card-title card_title_center">{{ __('supplierCategory.supplier_categories_data') }}</h3>
                    <a class="btn btn-success"
                        href="{{ route('suppliers_category.create') }}">{{ __('supplierCategory.add_new') }}</a>
                </div>

                <div class="card-body">

                    @if (isset($data) && count($data) > 0)
                        <div id="ajax_responce_searchDiv">

                            <table class="table table-bordered table-hover text-center">
                                <thead class="custom_head">
                                    <tr>
                                        <th>{{ __('supplierCategory.serial') }}</th>
                                        <th>{{ __('supplierCategory.category_name') }}</th>
                                        <th>{{ __('supplierCategory.status') }}</th>
                                        <th>{{ __('supplierCategory.created_at') }}</th>
                                        <th>{{ __('supplierCategory.updated_at') }}</th>
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
                                                    <span
                                                        class="badge badge-success">{{ __('supplierCategory.active') }}</span>
                                                @else
                                                    <span
                                                        class="badge badge-danger">{{ __('supplierCategory.inactive') }}</span>
                                                @endif
                                            </td>

                                            <td>
                                                @if ($item['created_at'] != null)
                                                    {{ $item['created_at']->format('Y-m-d h:i') . ' ' . ($item['created_at']->format('A') == 'AM' ? __('supplierCategory.am') : __('supplierCategory.pm')) }}
                                                    {{ __('supplierCategory.by') }} {{ __('supplierCategory.by') }}
                                                    {{ $item['added_by_admin'] }}
                                                @else
                                                    {{ __('supplierCategory.none') }}
                                                @endif

                                            </td>

                                            <td>
                                                @if ($item['updated_by'] > 0 && $item['updated_at'] != null)
                                                    {{ $item['updated_at']->format('Y-m-d h:i') . ' ' . ($item['updated_at']->format('A') == 'AM' ? __('supplierCategory.am') : __('supplierCategory.pm')) }}
                                                    {{ __('supplierCategory.by') }}
                                                    {{ $item['updated_by_admin'] }}
                                                @else
                                                    {{ __('supplierCategory.none') }}
                                                @endif
                                            </td>


                                            <td>
                                                <a href="{{ route('suppliers_category.edit', $item->id) }}"
                                                    class="btn btn-primary">{{ __('supplierCategory.edit') }}</a>

                                                <form action="{{ route('suppliers_category.destroy', $item->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('{{ __('supplierCategory.confirm_delete') }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-danger">{{ __('supplierCategory.delete') }}</button>
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
                            {{ __('supplierCategory.no_data') }}
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
