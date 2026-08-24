@extends('layouts.admin')

@section('title')
    {{ __('category.add_new_category') }}
@endsection

@section('contentheader')
{{ __('category.title') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('category.index') }}">  {{ __('category.title') }} </a>
@endsection

@section('contentheaderactive')
{{ __('category.add_new') }}
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
                    <h3 class="card-title card_title_center">{{ __('category.add_new_category') }}</h3>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger text-center">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('category.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>{{ __('category.category_name') }} </label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ __('category.status') }}</label>
                            <select name="active" class="form-control">
                                <option value="" selected disabled>{{ __('category.choose_status') }}</option>
                                <option value="1">{{ __('category.active') }}</option>
                                <option value="0">{{ __('category.inactive') }}</option>
                            </select>
                            @error('active')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary m-2">
                            {{ __('category.save') }}
                        </button>

                        <a href="{{ route('category.index') }}" class="btn btn-secondary">
                            {{ __('category.cancel') }}
                        </a>

                    </form>

                </div>

            </div>
        </div>
    </div>
@endsection
