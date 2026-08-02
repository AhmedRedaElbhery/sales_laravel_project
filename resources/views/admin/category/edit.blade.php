@extends('layouts.admin')

@section('title')
    {{ __('category.edit_categories') }}
@endsection

@section('contentheader')
{{ __('category.edit_categories') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('category.index') }}"> {{ __('category.title') }} </a>
@endsection

@section('contentheaderactive')
{{ __('category.edit_categories_data') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title card_title_center">{{ __('category.edit_categories_data') }} </h3>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger text-center">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('category.update',$data['id']) }}" method="POST">
                        @csrf
                        @method('put')

                        <div class="form-group">
                            <label>{{ __('category.category_name') }} </label>
                            <input type="text" name="name" class="form-control" value="{{ $data->name }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ __('category.status') }}</label>

                            <select name="active" class="form-control">
                                <option value="" disabled>{{ __('category.choose_status') }}</option>

                                <option value="1"
                                    {{ old('active', $data->active) == 1 ? 'selected' : '' }}>
                                    {{ __('category.active') }}
                                </option>

                                <option value="0"
                                    {{ old('active', $data->active) == 0 ? 'selected' : '' }}>
                                    {{ __('category.inactive') }}
                                </option>
                            </select>

                            @error('active')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
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
