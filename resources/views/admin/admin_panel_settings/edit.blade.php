@extends('layouts.admin');

@section('title')
    {{ __('adminPanelSettings.edit_general_settings') }}
@endsection

@section('contentheader')
    {{ __('adminPanelSettings.settings') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin.adminpanelsettings.index') }}"> {{ __('adminPanelSettings.settings') }} </a>
@endsection


@section('contentheaderactive')
    نعديل
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center"> {{ __('adminPanelSettings.edit_settings_general_data') }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if (@isset($data) && !@empty($data))
                        <form action="{{ route('admin.adminpanelsettings.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label>{{ __('adminPanelSettings.company_name') }}</label>
                                <input type="text" name="system_name" class="form-control"
                                    value="{{ $data['system_name'] }}" required>
                                @error('system_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label>{{ __('adminPanelSettings.company_address') }}</label>
                                <input type="text" name="address" class="form-control" value="{{ $data['address'] }}">
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label>{{ __('adminPanelSettings.company_phone') }}</label>
                                <input type="text" name="phone" class="form-control" value="{{ $data['phone'] }}">
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>{{ __('adminPanelSettings.customer_parent_account') }}  </label>
                                <select name="customer_parent_account_number" class="form-control" >

                                    <option value="" selected disabled>{{ __('adminPanelSettings.choose_account') }}    </option>

                                    @foreach ($accounts as $item)
                                        <option value="{{ $item->account_number }}" @if($item->account_number == $data['customer_parent_account_number'] ) selected
                                        @endif  @selected(old('customer_parent_account_number') == $item->account_number)>{{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('customer_parent_account_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>{{ __('adminPanelSettings.supplier_parent_account') }}   </label>
                                <select name="supplier_parent_account_number" class="form-control" >

                                    <option value="" selected disabled>{{ __('adminPanelSettings.choose_account') }}  </option>

                                    @foreach ($accounts as $item)
                                        <option value="{{ $item->account_number }}" @if($item->account_number == $data['supplier_parent_account_number'] ) selected
                                        @endif  @selected(old('supplier_parent_account_number') == $item->account_number)>{{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('supplier_parent_account_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label>{{ __('adminPanelSettings.delegate_parent_account') }}   </label>
                                <select name="delegate_parent_account_number" class="form-control" >

                                    <option value="" selected disabled>{{ __('adminPanelSettings.choose_account') }}  </option>

                                    @foreach ($accounts as $item)
                                        <option value="{{ $item->account_number }}" @if($item->account_number == $data['delegate_parent_account_number'] ) selected
                                        @endif  @selected(old('delegate_parent_account_number') == $item->account_number)>{{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('delegate_parent_account_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>{{ __('adminPanelSettings.employess_parent_account') }}   </label>
                                <select name="employess_parent_account_number" class="form-control" >

                                    <option value="" selected disabled>{{ __('adminPanelSettings.choose_account') }}  </option>

                                    @foreach ($accounts as $item)
                                        <option value="{{ $item->account_number }}" @if($item->account_number == $data['employess_parent_account_number'] ) selected
                                        @endif  @selected(old('employess_parent_account_number') == $item->account_number)>{{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('employess_parent_account_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="form-group mb-3">
                                <label>{{ __('adminPanelSettings.general_alert') }} </label>
                                <textarea name="general_alert" class="form-control" rows="4">{{ $data['general_alert'] }}</textarea>
                                @error('general_alert')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label>{{ __('adminPanelSettings.company_logo') }} </label>

                                <div class="mb-2">
                                    <img class="custom_img" src="{{ asset('assets/admin/uploads/' . $data['photo']) }}"
                                        alt="image not found">

                                </div>

                                <input type="file" name="photo" class="form-control">
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success">
                                    {{ __('adminPanelSettings.save_updates') }}
                                </button>
                            </div>
                        </form>
                    @endif

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
@endsection
