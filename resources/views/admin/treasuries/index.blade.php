@extends('layouts.admin');

@section('title')
    الضبط العام
@endsection

@section('contentheader')
    الخزن
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin.treasuries.index') }}"> الخزن </a>
@endsection


@section('contentheaderactive')
    عرض
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">بيانات الخزن</h3>
                    <a class="btn btn-success" href="{{ route('admin.treasuries.create') }}">اضافه جديد</a>
                </div>

                <div class="card-body">

                    @if (isset($data) && count($data) > 0)
                        <table class="table table-bordered table-hover text-center">
                            <thead class="custom_head">
                                <tr>
                                    <th>التسلسل</th>
                                    <th>اسم الخزن</th>
                                    <th>هل رئيسيه</th>
                                    <th>حاله التفعيل</th>
                                    <th>الكود</th>
                                    <th>آخر ايصال صرف</th>
                                    <th>آخر ايصال تحصيل</th>
                                    <th>تاريخ الاضافه</th>
                                    <th>تاريخ التحديث</th>
                                    <th> </th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>

                                        <td>{{ $item->name }}</td>

                                        <td>
                                            @if ($item->is_master == 1)
                                                رئيسية
                                            @else
                                                فرعية
                                            @endif
                                        </td>

                                        <td>
                                            @if ($item->active == 1)
                                                <span class="badge badge-success">مفعل</span>
                                            @else
                                                <span class="badge badge-danger">معطل</span>
                                            @endif
                                        </td>

                                        <td>{{ $item->com_code }}</td>
                                        <td>{{ $item->last_isal_exchange }}</td>
                                        <td>{{ $item->last_isal_collect }}</td>
                                        <td>
                                            @if ($item['added_by'] > 0 && $item['added_by'] != null)
                                                @php
                                                    $dt = new DateTime($item['created_at']);
                                                    $date = $dt->format('Y-m-d');
                                                    $time = $dt->format('h-i');
                                                    $newdatetime = date('A', strtotime($time));
                                                    $newdatetimetype = $newdatetime == 'PM' ? 'صباحا' : 'مساء';
                                                @endphp
                                                {{ $date }}<br>
                                                {{ $time }}
                                                {{ $newdatetimetype }}<br>
                                                بواسطه
                                                {{ $item['added_by_admin'] }}
                                            @else
                                                لا يوجد
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item['updated_by'] > 0 && $item['updated_by'] != null)
                                                @php
                                                    $dt = new DateTime($data['updated_at']);
                                                    $date = $dt->format('Y-m-d');
                                                    $time = $dt->format('h-i');
                                                    $newdatetime = date('A', strtotime($time));
                                                    $newdatetimetype = $newdatetime == 'PM' ? 'صباحا' : 'مساء';
                                                @endphp
                                                {{ $date }} <br>
                                                {{ $time }}
                                                {{ $newdatetimetype }}<br>
                                                بواسطه
                                                {{ $item['updated_by_admin'] }}
                                            @else
                                                لا يوجد
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-primary">تعديل</button>
                                            <button class="btn btn-info">المزيد</button>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br>
                        <div class="mt-3">
                            {{ $data->links() }}
                        </div>
                    @else
                        <div class="alert alert-warning">
                            لا توجد بيانات
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </div>
@endsection
