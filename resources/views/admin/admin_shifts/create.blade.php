@extends('layouts.admin')

@section('title')
    {{ __('adminShifts.title') }}
@endsection

@section('contentheader')
    {{ __('adminShifts.content_header') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin_shifts.index') }}">
        {{ __('adminShifts.content_header_link') }}
    </a>
@endsection

@section('contentheaderactive')
    {{ __('adminShifts.create') }}
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
                    <h3 class="card-title card_title_center">
                        {{ __('adminShifts.receive_new_shift') }}
                    </h3>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger text-center">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('admin_shifts.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>{{ __('adminShifts.available_treasuries') }}</label>

                            <select name="treasuries_id" class="form-control">
                                <option value="" selected disabled>
                                    {{ __('adminShifts.select_treasury') }}
                                </option>

                                @foreach ($treasuries as $item)
                                    @if ($item->status == true)
                                        <option value="{{ $item->treasuries_id }}">
                                            {{ $item->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>

                            @error('treasuries_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary m-2">
                            {{ __('adminShifts.save') }}
                        </button>

                        <a href="{{ route('admin_shifts.index') }}" class="btn btn-secondary">
                            {{ __('adminShifts.back') }}
                        </a>

                    </form>


                </div>

            </div>
        </div>
    </div>
@endsection