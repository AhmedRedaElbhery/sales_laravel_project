@extends('layouts.admin');

@section('title')
{{ __('customers.page_title') }}
@endsection

@section('contentheader')
{{ __('customers.accounts') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('customers.index') }}"> {{ __('customers.page_title') }} </a>
@endsection

@section('contentheaderactive')
{{ __('customers.add_new') }}
@endsection

@section('content')
    <div class="card">

        <div class="card-header">
            <h3 class="card-title card_title_center">{{ __('customers.add_new_account') }}</h3>
        </div>

        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger text-center">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('customers.store') }}" method="POST">
                @csrf
                <div>
                    <div class="row mb-2">

                        <div class="form-group col-sm-6">
                            <label>{{ __('customers.name') }} </label>
                            <input type="text" name="name" class="form-control"  value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label>{{ __('customers.address') }} </label>
                            <input type="text" name="address" class="form-control"  value="{{ old('address') }}">
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                    </div>


                    <div class="row mb-2">

                        <div class="form-group col-sm-6">
                            <label>{{ __('customers.status') }} </label>
                            <select name="active" class="form-control" >
                                <option value="" selected disabled>{{ __('customers.choose_status') }} </option>
                                <option value="1"  @selected(old('active') == 1)> {{ __('customers.active') }} </option>
                                <option value="0"  @selected(old('active') === '0')> {{ __('customers.inactive') }} </option>
                            </select>
                            @error('active')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label>{{ __('customers.account_type') }} </label>
                            <select name="start_balance_status" id="start_balance_status" class="form-control" >
                                <option value="" selected disabled>{{ __('customers.choose_account_type') }} </option>
                                <option value="1"  @selected(old('start_balance_status') == 1)> {{ __('customers.creditor') }} </option>
                                <option value="2" @selected(old('start_balance_status') == 2)> {{ __('customers.debtor') }} </option>
                                <option value="3" @selected(old('start_balance_status') == 3)> {{ __('customers.balanced') }} </option>
                            </select>
                            @error('start_balance_status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                    </div>

                    <div class="row mb-2">


                        <div class="form-group col-sm-6">
                            <label> {{ __('customers.start_balance') }} </label> <br>
                            <input style="width: 570px; height: 38px" type="number" name="start_balance" id="start_balance"
                            placeholder="{{ __('customers.balance') }} " value="{{ old('start_balance') }}">
                            @error('start_balance')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label>{{ __('customers.notes') }} </label> <br>
                            <textarea name="notes" style="height: 100px; width: 580px"></textarea>
                            @error('notes')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                </div>

                <button type="submit" class="btn btn-primary m-5 p-2 col-sm-5">
                    {{ __('customers.save') }}
                </button>

                <a href="{{ route('customers.index') }}" class="btn btn-secondary m-4 p-2 col-sm-5">
                    {{ __('customers.cancel') }}
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
