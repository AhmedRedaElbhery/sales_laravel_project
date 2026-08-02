@extends('layouts.admin');

@section('title')
    {{ __('collect.page_title') }}
@endsection

@section('contentheader')
{{ __('collect.page_title') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('collect_transaction.index') }}">  {{ __('collect.page_title') }} </a>
@endsection


@section('contentheaderactive')
{{ __('collect.view') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title card_title_center"> {{ __('collect.collection_screen_data') }}</h3>
                </div>



                <div class="card-body">


                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif


                    @if ($exist != null)
                        <form action="{{ route('collect_transaction.store') }}" method="POST"
                            style="border: 1px solid gray; padding: 10px">
                            @csrf

                            <div>
                                <div class="row mb-2">

                                    <div class="form-group col-sm-4">
                                        <label>{{ __('collect.available_treasury') }} </label>
                                        <select name="treasuries_id" id="treasuries_id" class="form-control">
                                            <option value="{{ $exist->treasuries_id }}"
                                                {{ old('treasuries_id', $exist->treasuries_id) == $exist->treasuries_id ? 'selected' : '' }}>
                                                {{ $exist->treasuries_name }}
                                            </option>
                                        </select>
                                        @error('treasuries_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-4">
                                        <label>{{ __('collect.movement_type') }} </label>
                                        <select name="move_type" id="move_type" class="form-control">
                                            <option value="" selected disabled>{{ __('collect.select_movement_type') }}</option>
                                            @foreach ($move_types as $move_type)
                                            <option value="{{ $move_type->id }}"
                                                {{ old('move_type') == $move_type->id ? 'selected' : '' }}>
                                                {{ $move_type->name }}
                                            </option>

                                            @endforeach
                                        </select>
                                        @error('move_type')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-4">
                                        <label>{{ __('collect.select_account') }} </label>
                                        <select name="account_number" id="start_balance_status" class="form-control">
                                            <option value="" disabled {{ old('account_number') ? '' : 'selected' }}>
                                                {{ __('collect.select_account') }}
                                            </option>

                                            @foreach ($accounts as $account)
                                                <option value="{{ $account->account_number }}"
                                                    {{ old('account_number') == $account->account_number ? 'selected' : '' }}>
                                                    {{ $account->name }} ({{ $account->account_type_name }})
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('account_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>



                                </div>

                                <div class="row">

                                    <div class="form-group col-4">
                                        <label>{{ __('collect.available_treasury_balance') }}</label>
                                        <input readonly class="form-control" type="number" name="treasuries_balance"
                                            value="{{ old('treasuries_balance', $treasuries_balance/100) }}">

                                        @error('treasuries_balance')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-4">
                                        <label>{{ __('collect.movement_date') }}</label>
                                        <input class="form-control" type="date" name="date"
                                            value="{{ old('date') }}">

                                        @error('date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-4">
                                        <label>{{ __('collect.collected_amount') }}</label>
                                        <input class="form-control" type="number" name="money" id="money"
                                            value="{{ old('money') }}">

                                        @error('money')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="form-group col-sm-6">
                                        <label>{{ __('collect.description') }}</label>
                                        <textarea name="byan" class="form-control" style="height: 100px;">{{ old('byan') }}</textarea>

                                        @error('byan')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>

                            </div>

                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary m-2" style="padding: 8px 15px;">
                                    {{ __('collect.collect') }}
                                </button>
                            </div>

                        </form>
                    @else
                        <div class="alert alert-danger">
                            {{ __('collect.no_open_shift') }}
                        </div>
                    @endif


                    @if (isset($data) && count($data) > 0)
                        <div id="ajax_responce_searchDiv">

                            <table class="table table-bordered table-hover text-center">
                                <thead class="custom_head">
                                    <tr>
                                        <th>{{ __('collect.receipt_number') }}</th>
                                        <th>{{ __('collect.treasury') }}</th>
                                        <th>{{ __('collect.amount') }}</th>
                                        <th>{{ __('collect.movement_type_table') }}</th>
                                        <th>{{ __('collect.movement_description') }}</th>
                                        <th>{{ __('collect.user') }}</th>

                                        <th> </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{$item->isal_number }}</td>

                                            <td>{{ $item->treasuries_name }}</td>

                                            <td>
                                                {{ $item->money_for_account / -100 }}
                                            </td>

                                            <td>
                                                {{ $item->move_type_name }}
                                            </td>

                                            <td>
                                                {{ $item->byan }}
                                            </td>

                                            <td>{{ $item->created_at }} <br> {{ __('collect.by') }} {{ $item->admin_name }}</td>

                                            <td>
                                                <a href="#"
                                                    class="btn btn-primary">{{ __('collect.print') }}</a>
                                                <a href="#"
                                                    class="btn btn-info">{{ __('collect.more') }}</a>
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
                            {{ __('collect.no_data') }}
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
