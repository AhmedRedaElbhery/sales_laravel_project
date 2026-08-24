@extends('layouts.admin');

@section('title')
    {{ __('items.title') }}
@endsection

@section('contentheader')
{{ __('items.title') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('itemcard.index') }}">  {{ __('items.title') }} </a>
@endsection


@section('contentheaderactive')
{{ __('items.show') }}
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
                    <h3 class="card-title card_title_center"> {{ __('items.items_data') }} </h3>
                    <a class="btn btn-success" href="{{ route('itemcard.create') }}"> {{ __('items.add_new') }}</a>
                </div>

                <div class="card-body">

                    <div class="col-md-4">
                        <input type="text" id="search_by_name" placeholder=" {{ __('items.search_by_name') }}" class="form-control mb-3">
                    </div>

                    @if (isset($data) && count($data) > 0)
                        <div id="ajax_responce_searchDiv">

                            <table class="table table-bordered table-hover text-center">
                                <thead class="custom_head">
                                    <tr>

                                        <th> {{ __('items.name') }}</th>
                                        <th> {{ __('items.type') }}</th>
                                        <th> {{ __('items.category') }} </th>
                                        <th> {{ __('items.parent_item') }} </th>
                                        <th> {{ __('items.parent_unit') }} </th>
                                        <th> {{ __('items.retail_unit') }} </th>
                                        <th> {{ __('items.quantity') }}</th>
                                        <th> {{ __('items.status') }}</th>
                                        <th> </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>

                                            <td>{{ $item->name }}</td>
                                            <td>
                                                @if ($item->item_type == 1)
                                                    <span class="badge badge-success"> {{ __('items.stock_item') }}</span>
                                                @elseif($item->item_type == 2)
                                                    <span class="badge badge-success"> {{ __('items.consumable_expiry') }}</span>
                                                @elseif($item->item_type == 3)
                                                    <span class="badge badge-success"> {{ __('items.asset_item') }}</span>
                                                @else
                                                    <span class="badge badge-danger"> {{ __('items.undefined') }} </span>
                                                @endif
                                            </td>

                                            <td>{{ $item->category_name }}</td>
                                            <td>
                                                @if ($item->parent_id == 0)
                                                    {{  __('items.main_item')}}
                                                @else
                                                    @foreach ($data as $items)
                                                        @if ($items->id == $item->parent_id)
                                                            {{ $items->name }}
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </td>

                                            <td>{{ $item->unit_name }}</td>

                                            <td>{{ $item->retail_unit_name }}</td>

                                            <td>{{ $item->quantity * 1}} ووحدتها {{ $item->unit_name}}</td>

                                            <td>
                                                @if ($item->active == 1)
                                                    <span class="badge badge-success">{{ __('items.active') }}</span>
                                                @else
                                                    <span class="badge badge-danger">{{ __('items.inactive') }}</span>
                                                @endif
                                            </td>

                                            <td>
                                                <a href="{{ route('itemcard.edit', $item->id) }}"
                                                    class="btn btn-primary">{{ __('items.edit') }}</a>

                                                    <a href="{{ route('itemcard.show', $item->id) }}"
                                                        class="btn btn-info">{{ __('items.show') }}</a>

                                                <form action="{{ route('itemcard.destroy', $item->id) }}" method="POST"
                                                    class="d-inline" onsubmit="return confirm('{{ __('items.confirm_delete') }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">{{ __('items.delete') }}</button>
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
                            {{ __('items.no_data') }}
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
