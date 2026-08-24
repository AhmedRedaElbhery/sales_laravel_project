@extends('layouts.admin')

@section('title')
    {{ __('stores.add_new_store') }}
@endsection

@section('contentheader')
{{ __('stores.title') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin.store.index') }}">  {{ __('stores.title') }} </a>
@endsection

@section('contentheaderactive')
{{ __('stores.add_new') }}
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
                    <h3 class="card-title card_title_center">{{ __('stores.add_new_store') }}</h3>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger text-center">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.store.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>{{ __('stores.store_name') }}  </label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ __('stores.phone') }}  </label>
                            <input type="number" name="phone" class="form-control" value="{{ old('phone') }}">
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ __('stores.address') }}   </label>
                            <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ __('stores.active_status') }}</label>
                            <select name="active" class="form-control">
                                <option value="" selected disabled>{{ __('stores.choose_status') }}</option>
                                <option value="1">{{ __('stores.active') }}</option>
                                <option value="0">{{ __('stores.inactive') }}</option>
                            </select>
                            @error('active')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary m-2">
                            {{ __('stores.save') }}
                        </button>

                        <a href="{{ route('admin.store.index') }}" class="btn btn-secondary">
                            {{ __('stores.cancel') }}
                        </a>

                    </form>

                </div>

            </div>
        </div>
    </div>
@endsection
