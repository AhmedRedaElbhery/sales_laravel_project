@extends('layouts.admin');

@section('title')
    {{ __('supplierAccounts.page_title') }}
@endsection

@section('contentheader')
{{ __('supplierAccounts.page_title') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('customers.index') }}"> {{ __('supplierAccounts.page_title') }} </a>
@endsection

@section('contentheaderactive')
{{ __('supplierAccounts.edit') }}
@endsection

@section('content')
    <div class="card">

        <div class="card-header">
            <h3 class="card-title card_title_center">تعديل حساب المورد</h3>
        </div>

        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger text-center">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('suppliers.update', $data->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div>

                    <div class="row mb-2">

                        <div class="form-group col-sm-6">
                            <label>{{ __('supplierAccounts.name') }} </label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $data->name) }}">

                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label>{{ __('supplierAccounts.address') }} </label>
                            <input type="text" name="address" class="form-control"
                                value="{{ old('address', $data->address) }}">

                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="row mb-2">

                        <div class="form-group col-sm-6">
                            <label>{{ __('supplierAccounts.supplier_category') }} </label>
                            <select name="category_id" class="form-control">
                                <option value="" disabled>{{ __('supplierAccounts.choose_category') }} </option>

                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @if ($category->id == $data['supplier_category_id']) selected @endif>
                                        {{ $category->name }} </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="form-group col-sm-6">
                            <label>{{ __('supplierAccounts.status') }}</label>

                            <select name="active" class="form-control">
                                <option value="" disabled>{{ __('supplierAccounts.choose_status') }}</option>

                                <option value="1" @selected(old('active', $data->active) == 1)>
                                    {{ __('supplierAccounts.active') }}
                                </option>

                                <option value="0" @selected(old('active', $data->active) == 0)>
                                    {{ __('supplierAccounts.inactive') }}
                                </option>
                            </select>

                            @error('active')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="form-group col-sm-6">
                        <label>{{ __('supplierAccounts.notes') }}</label> <br>

                        <textarea name="notes" style="height: 80px; width: 580px">{{ old('notes', $data->notes) }}</textarea>

                        @error('notes')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>



                </div>

                <button type="submit" class="btn btn-primary m-5 p-2 col-sm-5">
                    {{ __('supplierAccounts.update') }}
                </button>

                <a href="{{ route('suppliers.index') }}" class="btn btn-secondary m-4 p-2 col-sm-5">
                    {{ __('supplierAccounts.cancel') }}
                </a>

            </form>

        </div>

    </div>
@endsection

@section('script')
@endsection
