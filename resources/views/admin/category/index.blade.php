@extends('layouts.admin');

@section('title')
{{ __('category.title') }}
@endsection

@section('contentheader')
{{ __('category.title') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('category.index') }}"> {{ __('category.title') }}
    </a>
@endsection


@section('contentheaderactive')
{{ __('category.show') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title card_title_center">{{ __('category.categories_data') }}</h3>
                    <a class="btn btn-success" href="{{ route('category.create') }}">{{ __('category.add_new') }}</a>
                </div>

                <div class="card-body">

                    @if (isset($data) && count($data) > 0)
                        <div id="ajax_responce_searchDiv">

                            <table class="table table-bordered table-hover text-center">
                                <thead class="custom_head">
                                    <tr>
                                        <th>{{ __('category.serial') }}</th>
                                        <th>{{ __('category.category_name') }}</th>
                                        <th>{{ __('category.status') }}</th>
                                        <th>{{ __('category.created_at') }}</th>
                                        <th>{{ __('category.updated_at') }}</th>
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
                                                    <span class="badge badge-success">{{ __('category.active') }}</span>
                                                @else
                                                    <span class="badge badge-danger">{{ __('category.inactive') }}</span>
                                                @endif
                                            </td>

                                            <td>
                                                @if ($item['created_at'] != null)
                                                {{ $item['created_at']->format('Y-m-d h:i') . ' ' . ($item['created_at']->format('A') == 'AM' ?  __('category.am') :  __('category.pm')) }}
                                                {{ __('category.by') }}
                                                    {{ $item['added_by_admin'] }}
                                                @else
                                                {{ __('category.not_fount') }}
                                                @endif

                                            </td>

                                            <td>
                                                @if ($item['updated_by'] > 0 && $item['updated_at'] != null)
                                                {{ $item['updated_at']->format('Y-m-d h:i') . ' ' . ($item['updated_at']->format('A') == 'AM' ? __('category.am') :  __('category.pm')) }}
                                                {{ __('category.by') }}
                                                    {{ $item['updated_by_admin'] }}
                                                @else
                                                {{ __('category.not_found') }}
                                                @endif
                                            </td>


                                            <td>
                                                <a href="{{ route('category.edit', $item->id) }}"
                                                    class="btn btn-primary">{{ __('category.edit') }}</a>

                                                <form action="{{ route('category.destroy', $item->id) }}"
                                                    method="POST"
                                                    class="d-inline" onsubmit="return confirm('{{ __('category.confirm_delete') }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">{{ __('category.delete') }}</button>
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
                            {{ __('category.no_data') }}
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
