@extends('layouts.admin');

@section('title')
    {{ __('adminpanelsettings.title') }}
@endsection

@section('contentheader')
    {{ __('adminpanelsettings.title') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin.adminpanelsettings.index') }}">{{ __('adminpanelsettings.settings') }} </a>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center"> {{ __('adminpanelsettings.general_settings_data') }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if (@isset($data) && !@empty($data))
                        <table id="example2" class="table table-bordered table-hover">
                            <tr>
                                <td class="width30">{{ __('adminpanelsettings.company_name') }}</td>
                                <td>{{ $data['system_name'] }}</td>
                            </tr>

                            <tr>
                                <td>{{ __('adminpanelsettings.company_code') }}</td>
                                <td>{{ $data['com_code'] }}</td>
                            </tr>

                            <tr>
                                <td>{{ __('adminpanelsettings.company_status') }}</td>
                                <td>
                                    @if ($data['active'] == 1)
                                        {{ __('adminpanelsettings.active') }}
                                    @else
                                        {{ __('adminpanelsettings.inactive') }}
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td>{{ __('adminpanelsettings.company_address') }}</td>
                                <td>{{ $data['address'] }}</td>
                            </tr>

                            <tr>
                                <td>{{ __('adminpanelsettings.company_phone') }}</td>
                                <td>{{ $data['phone'] }}</td>
                            </tr>

                            <tr>
                                <td>{{ __('adminpanelsettings.general_alert') }}</td>
                                <td>{{ $data['general_alert'] }}</td>
                            </tr>

                            <tr>
                                <td>{{ __('adminpanelsettings.company_logo') }}</td>
                                <td>
                                    <div class="image">
                                        <img class="custom_img"
                                            src="{{ asset('assets/admin/uploads') . '/' . $data['photo'] }}"
                                            alt="image not found">
                                    </div>
                                </td>
                            </tr>


                            <tr>
                                <td>{{ __('adminpanelsettings.customer_parent_account') }} </td>
                                <td>{{ $data['customer_parent_account_name'] }}
                                    {{ __('adminpanelsettings.account_number') }}
                                    ({{ $data['customer_parent_account_number'] }})</td>
                            </tr>

                            <tr>
                                <td>{{ __('adminpanelsettings.supplier_parent_account') }} </td>
                                <td>{{ $data['supplier_parent_account_name'] }}
                                    {{ __('adminpanelsettings.account_number') }}
                                    ({{ $data['supplier_parent_account_number'] }})</td>
                            </tr>

                            <tr>
                                <td>{{ __('adminpanelsettings.delegate_parent_account') }} </td>
                                <td>{{ $data['delegate_parent_account_name'] }}
                                    {{ __('adminpanelsettings.account_number') }}
                                    ({{ $data['delegate_parent_account_number'] }})</td>
                            </tr>

                            <tr>
                                <td>{{ __('adminpanelsettings.employess_parent_account') }} </td>
                                <td>{{ $data['employess_parent_account_name'] }}
                                    {{ __('adminpanelsettings.account_number') }}
                                    ({{ $data['employess_parent_account_number'] }})</td>
                            </tr>

                            <tr>
                                <td>{{ __('adminpanelsettings.last_update') }} </td>
                                <td>
                                    @if ($data['updated_by'] > 0 && $data['updated_by'] != null)
                                        @php
                                            $dt = new DateTime($data['updated_at']);
                                            $date = $dt->format('Y-m-d');
                                            $time = $dt->format('h-i');
                                            $newdatetime = date('A', strtotime($time));
                                            $newdatetimetype =
                                                $newdatetime == 'AM'
                                                    ? __('adminpanelsettings.am')
                                                    : __('adminpanelsettings.pm');
                                        @endphp
                                        {{ $date }}
                                        {{ $time }}
                                        {{ $newdatetimetype }}
                                        {{ __('adminpanelsettings.by') }}
                                        {{ $data['updated_by_admin'] }}
                                    @else
                                        {{ __('adminpanelsettings.none') }}
                                    @endif
                                    <a href="{{ route('admin.adminpanelsettings.edit') }}"
                                        class="btn btn-primary">{{ __('adminpanelsettings.edit') }}</a>
                                </td>
                            </tr>

                        </table>
                    @endif

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
@endsection

@section('contentheaderactive')
    عرض
@endsection
