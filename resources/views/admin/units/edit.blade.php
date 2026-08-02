@extends('layouts.admin')

@section('title')
    {{ __('units.edit_unit') }}
@endsection

@section('contentheader')
{{ __('units.edit_unit') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('unit.index') }}"> {{ __('units.units') }} </a>
@endsection

@section('contentheaderactive')
{{ __('units.edit_unit_data') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title card_title_center">{{ __('units.edit_unit_data') }} </h3>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger text-center">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('unit.update',$data['id']) }}" method="POST">
                        @csrf
                        @method('put')

                        <div class="form-group">
                            <label>{{ __('units.unit_name') }} </label>
                            <input type="text" name="name" class="form-control" value="{{ $data->name }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>{{ __('units.unit_type') }}</label>

                            <select name="is_master" class="form-control">
                                <option value="" disabled>{{ __('units.choose_status') }}</option>

                                <option value="1"
                                    {{ old('is_master', $data->is_master) == 1 ? 'selected' : '' }}>
                                    {{ __('units.master_unit') }}
                                </option>

                                <option value="0"
                                    {{ old('is_master', $data->is_master) == 0 ? 'selected' : '' }}>
                                    {{ __('units.sub_unit') }}
                                </option>
                            </select>

                            @error('active')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label>{{ __('units.status') }}</label>

                            <select name="active" class="form-control">
                                <option value="" disabled>{{ __('units.choose_status') }}</option>

                                <option value="1"
                                    {{ old('active', $data->active) == 1 ? 'selected' : '' }}>
                                    {{ __('units.active') }}
                                </option>

                                <option value="0"
                                    {{ old('active', $data->active) == 0 ? 'selected' : '' }}>
                                    {{ __('units.inactive') }}
                                </option>
                            </select>

                            @error('active')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            {{ __('units.save') }}
                        </button>

                        <a href="{{ route('unit.index') }}" class="btn btn-secondary">
                            {{ __('units.cancel') }}
                        </a>

                    </form>

                </div>

            </div>
        </div>
    </div>
@endsection
