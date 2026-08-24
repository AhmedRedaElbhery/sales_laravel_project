@extends('layouts.admin')

@section('title')
    {{ __('salesCategories.add_new_category') }}
@endsection

@section('contentheader')
{{ __('salesCategories.page_title') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin.sales_material.index') }}">  {{ __('salesCategories.page_title') }} </a>
@endsection

@section('contentheaderactive')
{{ __('salesCategories.add_new') }}
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
                    <h3 class="card-title card_title_center">{{ __('salesCategories.add_new_category') }}</h3>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger text-center">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.sales_material.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>{{ __('salesCategories.category_name') }} </label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ __('salesCategories.status') }}</label>
                            <select name="active" class="form-control">
                                <option value="" selected disabled>{{ __('salesCategories.choose_status') }}</option>
                                <option value="1">{{ __('salesCategories.active') }}</option>
                                <option value="0">{{ __('salesCategories.inactive') }}</option>
                            </select>
                            @error('active')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary m-2">
                            {{ __('salesCategories.save') }}
                        </button>

                        <a href="{{ route('admin.sales_material.index') }}" class="btn btn-secondary">
                            {{ __('salesCategories.cancel') }}
                        </a>

                    </form>

                </div>

            </div>
        </div>
    </div>
@endsection
