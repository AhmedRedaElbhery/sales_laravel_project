@extends('layouts.admin');

@section('title')
    {{ __('itemCardBalance.title') }}
@endsection

@section('contentheader')
    {{ __('itemCardBalance.title') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('itemCardBalance.index') }}"> {{ __('itemCardBalance.title') }} </a>
@endsection


@section('contentheaderactive')
    {{ __('itemCardBalance.show') }}
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
                    <h3 class="card-title card_title_center"> {{ __('itemCardBalance.items_data') }} </h3>
                </div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" id="search_by_name"
                                placeholder=" {{ __('itemCardBalance.search_by_name') }}" class="form-control mb-3">
                        </div>

                        <div class="col-md-4">
                            <form action="{{ route('itemCardBalance.filter') }}" method="GET">
                                @csrf
                                <select name="store_id" class="form-control" onchange="this.form.submit()">
                                    @if (!isset($id))
                                        <option selected value="all">{{ __('itemCardBalance.all_stores') }}</option>
                                        @foreach ($stores as $store)
                                            <option value="{{ $store->id }}">{{ $store->name }}</option>
                                        @endforeach
                                    @else
                                        <option selected value="all">{{ __('itemCardBalance.all_stores') }}</option>
                                        @foreach ($stores as $store)
                                            <option @selected($id == $store->id) value="{{ $store->id }}">
                                                {{ $store->name }}</option>
                                        @endforeach
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

                                        <th style="width: 10%"> {{ __('itemCardBalance.code') }}</th>
                                        <th style="width: 20%"> {{ __('itemCardBalance.name') }}</th>
                                        @if (!isset($id))
                                            <th style="width: 70%"> {{ __('itemCardBalance.quantity_in_sotres') }}</th>
                                        @else
                                            <th style="width: 70%"> {{ __('itemCardBalance.quantity_in_specific_sotre') }}
                                            </th>
                                        @endif

                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>

                                            <td>{{ $item->item_code }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>
                                                {{ __('itemCardBalance.quantity') }} ( {{ $item->quantity * 1 }})
                                                {{ __('itemCardBalance.unit') }}
                                                ({{ $item->unit_name }})
                                                @if ($item->production_date != null)
                                                    {{ __('itemCardBalance.production_date') }}
                                                   ( {{ $item->production_date }} )
                                                    {{ __('itemCardBalance.end_date') }}
                                                   ( {{ $item->end_date }} )
                                                @endif
                                            </td>


                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <br>
                            @if (!isset($id))
                                <div class="mt-3">
                                    {{ $data->links() }}
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="alert alert-warning">
                            {{ __('itemCardBalance.no_data') }}
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
