@extends('layouts.admin');

@section('title')
    الضبط العام
@endsection

@section('contentheader')
    الضبط
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin.adminpanelsettings.index') }}"> الضبط </a>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">بيانات الضبط العام</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if (@isset($data) && !@empty($data))
                        <table id="example2" class="table table-bordered table-hover">
                                <tr>
                                    <td class="width30">اسم الشركه</td>
                                    <td>{{ $data['system_name'] }}</td>
                                </tr>

                                <tr>
                                    <td>كود الشركه</td>
                                    <td>{{ $data['com_code'] }}</td>
                                </tr>

                                <tr>
                                    <td>حاله الشركه</td>
                                    <td>
                                        @if ($data['active'] == 1)
                                            مفعل
                                        @else
                                            غير مفعل
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td>عنوان الشركه</td>
                                    <td>{{ $data['address'] }}</td>
                                </tr>

                                <tr>
                                    <td>هاتف الشركه</td>
                                    <td>{{ $data['phone'] }}</td>
                                </tr>

                                <tr>
                                    <td>رساله التنبيه اعلى الشاشه للشركه</td>
                                    <td>{{ $data['general_alert'] }}</td>
                                </tr>

                                <tr>
                                    <td>لوجو الشركه</td>
                                    <td>
                                        <div class="image">
                                            <img class="custom_img"
                                                src="{{ asset('assets/admin/uploads') . '/' . $data['photo'] }}" alt="image not found">
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>هاتف الشركه</td>
                                    <td>{{ $data['phone'] }}</td>
                                </tr>

                                <tr>
                                    <td>تاريخ اخر تحديث </td>
                                    <td>
                                        @if($data['updated_by']>0 && $data['updated_by']!= null)
                                        @php
                                        $dt = new DateTime($data['updated_at']);
                                        $date = $dt->format("Y-m-d");
                                        $time = $dt->format("h-i");
                                        $newdatetime = date("A" , strtotime($time));
                                        $newdatetimetype = (($newdatetime == 'PM')?'صباحا' : 'مساء');
                                        @endphp
                                        {{ $date }}
                                        {{ $time }}
                                        {{ $newdatetimetype }}
                                        بواسطه
                                        {{ $data['updated_by_admin'] }}
                                        @else
                                        لا يوجد
                                        @endif
                                        <a href="{{ route('admin.adminpanelsettings.edit') }}" class="btn btn-primary">تعديل</a>
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
