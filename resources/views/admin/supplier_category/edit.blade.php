@extends('layouts.admin');

@section('title')
{{ __('supplierCategory.page_title') }}
@endsection

@section('contentheader')
{{ __('supplierCategory.page_title') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('suppliers_category.index') }}"> {{ __('supplierCategory.page_title') }} </a>
@endsection


@section('contentheaderactive')
{{ __('supplierCategory.edit_category_data') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title card_title_center">{{ __('supplierCategory.edit_category_data') }} </h3>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger text-center">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('suppliers_category.update',$data['id']) }}" method="POST">
                        @csrf
                        @method('put')

                        <div class="form-group">
                            <label>{{ __('supplierCategory.category_name') }}</label>
                            <input type="text" name="name" class="form-control" value="{{ $data->name }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ __('supplierCategory.status') }}</label>

                            <select name="active" class="form-control">
                                <option value="" disabled>{{ __('supplierCategory.choose_status') }}</option>

                                <option value="1"
                                    {{ old('active', $data->active) == 1 ? 'selected' : '' }}>
                                    {{ __('supplierCategory.active') }}
                                </option>

                                <option value="0"
                                    {{ old('active', $data->active) == 0 ? 'selected' : '' }}>
                                    {{ __('supplierCategory.inactive') }}
                                </option>
                            </select>

                            @error('active')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            {{ __('supplierCategory.update') }}
                        </button>

                        <a href="{{ route('suppliers_category.index') }}" class="btn btn-secondary">
                            {{ __('supplierCategory.cancel') }}
                        </a>

                    </form>

                </div>

            </div>
        </div>
    </div>
@endsection
