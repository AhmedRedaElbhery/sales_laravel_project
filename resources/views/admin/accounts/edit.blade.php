@extends('layouts.admin')

@section('title')
    {{ __('accounts.edit_account') }}
@endsection

@section('contentheader')
{{ __('accounts.edit_account') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('accounts.index') }}"> {{ __('accounts.financial_accounts') }} </a>
@endsection

@section('contentheaderactive')
{{ __('accounts.edit') }}
@endsection

@section('content')
    <div class="card">

        <div class="card-header">
            <h3 class="card-title card_title_center">{{ __('accounts.edit_account') }}</h3>
        </div>

        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger text-center">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('accounts.update', $data->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div>

                    <div class="row mb-2">

                        <div class="form-group col-sm-6">
                            <label>{{ __('accounts.name') }} </label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $data->name) }}">

                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label>{{ __('accounts.account_type') }} </label>

                            <select name="account_type" class="form-control">
                                <option value="" selected disabled>{{ $account_type->name }}</option>
                            </select>

                            @error('account_type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="row mb-2">

                        <div class="form-group col-sm-6">
                            <label>{{ __('accounts.who_is_parent_account') }}</label>

                            <select name="parent_account_number" class="form-control">
                                <option value="" disabled>{{ __('accounts.select_parent_account') }}</option>

                                <option value="0"
                                    @selected(old('parent_account_number', $data->parent_account_number) == 0)>
                                    {{ __('accounts.this_is_parent_account') }}
                                </option>

                                @foreach ($accounts as $item)
                                @if ($item->id != $data->id)
                                <option value="{{ $item->id }}"
                                    @selected(old('parent_account_number', $data->parent_account_number) == $item->id)>
                                    {{ $item->name }}
                                </option>
                                @endif

                                @endforeach
                            </select>

                            @error('parent_account_number')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label>{{ __('accounts.select_status') }}</label>

                            <select name="is_archived" class="form-control">
                                <option value="" disabled>{{ __('accounts.select_status') }}</option>

                                <option value="0"
                                    @selected(old('is_archived', $data->is_archived) == 0)>
                                    {{ __('accounts.active') }}
                                </option>

                                <option value="1"
                                    @selected(old('is_archived', $data->is_archived) == 1)>
                                    {{ __('accounts.inactive') }}
                                </option>
                            </select>

                            @error('is_archived')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="form-group col-sm-5">
                        <label>{{ __('accounts.notes') }}</label> <br>

                        <textarea name="notes" style="height: 100px; width: 420px">{{ old('notes', $data->notes) }}</textarea>

                        @error('notes')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <button type="submit" class="btn btn-primary m-5 p-2 col-sm-5">
                    {{ __('accounts.update') }}
                </button>

                <a href="{{ route('accounts.index') }}" class="btn btn-secondary m-4 p-2 col-sm-5">
                    {{ __('accounts.cancel') }}
                </a>

            </form>

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