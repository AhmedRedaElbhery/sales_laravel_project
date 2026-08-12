@extends('layouts.admin');

@section('title')
{{ __('delegates.edit_delegate_account') }}
@endsection

@section('contentheader')
{{ __('delegates.accounts') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('delegate.index') }}"> {{ __('delegates.page_title') }} </a>
@endsection

@section('contentheaderactive')
{{ __('delegates.edit') }}
@endsection

@section('content')
    <div class="card">

        <div class="card-header">
            <h3 class="card-title card_title_center">{{ __('delegates.edit_delegate_account') }}</h3>
        </div>

        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger text-center">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('delegate.update', $data->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div>

                    <div class="row mb-2">

                        <div class="form-group col-sm-6">
                            <label>{{ __('delegates.name') }} </label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $data->name) }}">

                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label>{{ __('delegates.address') }} </label>
                            <input type="text" name="address" class="form-control"
                                value="{{ old('address', $data->address) }}">

                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="row mb-2">

                        <div class="form-group col-sm-6">
                            <label>{{ __('delegates.status') }}</label>

                            <select name="active" class="form-control">
                                <option value="" disabled>{{ __('delegates.choose_status') }}</option>

                                <option value="1"
                                    @selected(old('active', $data->active) == 1)>
                                    {{ __('delegates.active') }}
                                </option>

                                <option value="0"
                                    @selected(old('active', $data->active) == 0)>
                                    {{ __('delegates.inactive') }}
                                </option>
                            </select>

                            @error('active')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label>{{ __('delegates.notes') }}</label> <br>

                            <textarea name="notes" style="height: 80px; width: 580px">{{ old('notes', $data->notes) }}</textarea>

                            @error('notes')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>



                </div>

                <button type="submit" class="btn btn-primary m-5 p-2 col-sm-5">
                    {{ __('delegates.update') }}
                </button>

                <a href="{{ route('delegate.index') }}" class="btn btn-secondary m-4 p-2 col-sm-5">
                    {{ __('delegates.cancel') }}
                </a>

            </form>

        </div>

    </div>
@endsection

@section('script')
@endsection