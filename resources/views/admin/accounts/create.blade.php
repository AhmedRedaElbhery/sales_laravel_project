@extends('layouts.admin')

@section('title')
    {{ __('accounts.add_new_account') }}
@endsection

@section('contentheader')
{{ __('accounts.financial_accounts') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('itemcard.index') }}"> {{ __('accounts.financial_accounts') }} </a>
@endsection

@section('contentheaderactive')
{{ __('accounts.add') }}
@endsection

@section('content')
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
            <h3 class="card-title card_title_center">{{ __('accounts.add_new_account') }}</h3>
        </div>

        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger text-center">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('accounts.store') }}" method="POST">
                @csrf
                <div>
                    <div class="row mb-2">

                        <div class="form-group col-sm-6">
                            <label> {{ __('accounts.name') }} </label>
                            <input type="text" name="name" class="form-control"  value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label> {{ __('accounts.account_type') }} </label>
                            <select name="account_type" class="form-control" >
                                <option value="" selected disabled> {{ __('accounts.select_account_type') }} </option>

                                @foreach ($account_type as $item)
                                    <option value="{{ $item->id }}" @selected(old('account_type') == $item->id)>{{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('account_type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="row mb-2">

                        <div class="form-group col-sm-6">
                            <label> {{ __('accounts.who_is_parent_account') }}  </label>
                            <select name="parent_account_number" class="form-control" >

                                <option value="" selected disabled> {{ __('accounts.select_parent_account') }} </option>

                                <option value="0" @selected(old('parent_account_number') === '0')> {{ __('accounts.this_is_parent_account') }} </option>

                                @foreach ($accounts as $item)
                                    <option value="{{ $item->id }}" @selected(old('parent_account_number') == $item->id)>{{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_account_number')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="form-group col-sm-6">
                            <label> {{ __('accounts.status') }} </label>
                            <select name="is_archived" class="form-control" >
                                <option value="" selected disabled> {{ __('accounts.select_status') }} </option>
                                <option value="0"  @selected(old('is_archived') == 0)>  {{ __('accounts.active') }} </option>
                                <option value="1"  @selected(old('is_archived') == 1)>  {{ __('accounts.inactive') }} </option>
                            </select>
                            @error('is_archived')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="row mb-2">

                        <div class="form-group col-sm-6">
                            <label> {{ __('accounts.account_status') }} </label>
                            <select name="start_balance_status" id="start_balance_status" class="form-control" >
                                <option value="" selected disabled> {{ __('accounts.select_account_status') }} </option>
                                <option value="1"  @selected(old('start_balance_status') == 1)>  {{ __('accounts.creditor') }} </option>
                                <option value="2" @selected(old('start_balance_status') == 2)>  {{ __('accounts.debtor') }} </option>
                                <option value="3" @selected(old('start_balance_status') == 3)>  {{ __('accounts.balanced') }} </option>
                            </select>
                            @error('start_balance_status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-5">
                            <label> {{ __('accounts.opening_balance') }} </label> <br>
                            <input style="width: 570px; height: 38px" type="number" name="start_balance" id="start_balance"
                            placeholder=" {{ __('accounts.account_balance') }}" value="{{ old('start_balance') }}">
                            @error('start_balance')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group col-sm-5">
                        <label>{{ __('accounts.notes') }} </label> <br>
                        <textarea name="notes" style="height: 100px; width: 420px"></textarea>
                        @error('notes')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <button type="submit" class="btn btn-primary m-5 p-2 col-sm-5">
                    {{ __('accounts.save') }}
                </button>

                <a href="{{ route('accounts.index') }}" class="btn btn-secondary m-4 p-2 col-sm-5">
                    {{ __('accounts.cancel') }}
                </a>

            </form>

        </div>

    </div>
    </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            $('#start_balance_status').change(function() {

                if ($(this).val() == 3) {
                    $('#start_balance').val(0);
                }

            });

        });
    </script>
@endsection
