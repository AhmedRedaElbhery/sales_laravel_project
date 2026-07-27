@extends('layouts.admin')

@section('title')
    {{ __('treasuries.title') }}
@endsection

@section('contentheader')
{{ __('treasuries.title') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin.treasuries.index') }}">  {{ __('treasuries.title') }} </a>
@endsection

@section('contentheaderactive')
    إضافة
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">{{ __('treasuries.add_new') }}</h3>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger text-center">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.treasuries.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label> {{ __('treasuries.treasury_name') }}</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label> {{ __('treasuries.master') }}</label>
                            <select name="is_master" class="form-control">
                                <option value="" selected disabled> {{ __('treasuries.choose_type') }}</option>
                                <option value="0"> {{ __('treasuries.no') }}</option>
                                <option value="1"> {{ __('treasuries.yes') }}</option>
                            </select>
                            @error('is_master')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label> {{ __('treasuries.last_exchange_receipt') }}</label>
                            <input type="number" name="last_isal_exchange" class="form-control" value="">
                            @error('last_isal_exchange')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label> {{ __('treasuries.last_collect_receipt') }}</label>
                            <input type="number" name="last_isal_collect" class="form-control" value="">
                            @error('last_isal_collect')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ __('treasuries.status') }}</label>
                            <select name="active" class="form-control">
                                <option value="" selected disabled>{{ __('treasuries.choose_type') }}</option>
                                <option value="1">{{ __('treasuries.active') }}</option>
                                <option value="0">{{ __('treasuries.inactive') }}</option>
                            </select>
                            @error('active')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            {{ __('treasuries.save') }}
                        </button>

                        <a href="{{ route('admin.treasuries.index') }}" class="btn btn-secondary">
                            {{ __('treasuries.cancel') }}
                        </a>

                    </form>

                </div>

            </div>
        </div>
    </div>
@endsection
