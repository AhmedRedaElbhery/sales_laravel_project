@extends('layouts.admin')

@section('title')
    {{ __('stores.edit_store') }}
@endsection

@section('contentheader')
{{ __('stores.edit_store') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin.sales_material.index') }}"> {{ __('stores.title') }} </a>
@endsection

@section('contentheaderactive')
{{ __('stores.edit_store_data') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title card_title_center">{{ __('stores.edit_store_data') }} </h3>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger text-center">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.store.update',$data['id']) }}" method="POST">
                        @csrf
                        @method('put')

                        <div class="form-group">
                            <label>{{ __('stores.store_name') }} </label>
                            <input type="text" name="name" class="form-control" value="{{ $data->name }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ __('stores.phone') }}  </label>
                            <input type="number" name="phone" class="form-control" value="{{ $data->phone }}">
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ __('stores.address') }}   </label>
                            <input type="text" name="address" class="form-control" value="{{ $data->address }}">
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label>{{ __('stores.active_status') }}</label>

                            <select name="active" class="form-control">
                                <option value="" disabled>{{ __('stores.choose_status') }}</option>

                                <option value="1"
                                    {{ old('active', $data->active) == 1 ? 'selected' : '' }}>
                                    {{ __('stores.active') }}
                                </option>

                                <option value="0"
                                    {{ old('active', $data->active) == 0 ? 'selected' : '' }}>
                                    {{ __('stores.inactive') }}
                                </option>
                            </select>

                            @error('active')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
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
