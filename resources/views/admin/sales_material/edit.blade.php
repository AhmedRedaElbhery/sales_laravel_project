@extends('layouts.admin')
{{ __('salesCategories.edit_sales_category') }}
@section('title')

@endsection

@section('contentheader')
{{ __('salesCategories.edit_sales_category') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin.sales_material.index') }}"> {{ __('salesCategories.page_title') }} </a>
@endsection

@section('contentheaderactive')
{{ __('salesCategories.edit_sales_category_data') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title card_title_center">{{ __('salesCategories.edit_sales_category') }} </h3>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger text-center">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.sales_material.update',$data['id']) }}" method="POST">
                        @csrf
                        @method('put')

                        <div class="form-group">
                            <label>{{ __('salesCategories.category_name') }} </label>
                            <input type="text" name="name" class="form-control" value="{{ $data->name }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ __('salesCategories.status') }}</label>

                            <select name="active" class="form-control">
                                <option value="" disabled>{{ __('salesCategories.choose_status') }}</option>

                                <option value="1"
                                    {{ old('active', $data->active) == 1 ? 'selected' : '' }}>
                                    {{ __('salesCategories.active') }}
                                </option>

                                <option value="0"
                                    {{ old('active', $data->active) == 0 ? 'selected' : '' }}>
                                    {{ __('salesCategories.inactive') }}
                                </option>
                            </select>

                            @error('active')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            {{ __('salesCategories.save') }}
                        </button>

                        <a href="{{ route('admin.sales_material.index') }}" class="btn btn-secondary">
                            {{ __('salesCategories.cancle') }}
                        </a>

                    </form>

                </div>

            </div>
        </div>
    </div>
@endsection
