@extends('layouts.admin')

@section('title')
    {{ __('treasuries.add_new_branch') }}
@endsection

@section('contentheader')
    {{ __('treasuries.title') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin.treasuries.index') }}"> {{ __('treasuries.title') }} </a>
@endsection

@section('contentheaderactive')
{{ __('treasuries.add_new') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title"> {{ __('treasuries.add_new_branch') }}</h3>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger text-center">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.treasuries.store_treasuries_branch', $id) }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label> {{ __('treasuries.treasury_name') }}</label>
                            <select name="treasury_name" class="form-control">
                                <option value="" >{{ __('treasuries.choose_treasury') }} </option>
                                @foreach ($data as $treasury)
                                    <option value="{{ $treasury->id }}">{{ $treasury->name }}</option>
                                @endforeach
                            </select>
                            @error('treasury_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <button type="submit" class="btn btn-primary">
                            {{ __('treasuries.save') }}
                        </button>

                        <a href="{{ route('admin.treasuries.details', $id) }}" class="btn btn-secondary">
                            {{ __('treasuries.cancel') }}
                        </a>

                    </form>

                </div>

            </div>
        </div>
    </div>
@endsection
