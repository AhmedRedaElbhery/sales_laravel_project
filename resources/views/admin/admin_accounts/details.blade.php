@extends('layouts.admin');

@section('title')
    الصلاحيات
@endsection

@section('contentheader')
    المستخدمين
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin_accounts.index') }}"> المستخدمين </a>
@endsection

@section('contentheaderactive')
    عرض
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title card_title_center">بيانات المستخدم</h3>
                </div>

                <div class="card-body">
                    @if (isset($data))
                        <table id="example2" class="table table-bordered table-hover">
                            <tr>
                                <td class="width30">اسم المستخدم</td>
                                <td>{{ $data['name'] }}</td>
                            </tr>

                            <tr>
                                <td>تاريخ الاضافه </td>
                                <td>
                                    @if ($data['added_by'] > 0 && $data['added_by'] != null)
                                        @php
                                            $dt = new DateTime($data['created_at']);
                                            $date = $dt->format('Y-m-d');
                                            $time = $dt->format('h-i');
                                            $newdatetime = date('A', strtotime($time));
                                            $newdatetimetype = $newdatetime == 'AM' ? 'صباحا' : 'مساء';
                                        @endphp
                                        {{ $date }}
                                        {{ $time }}
                                        {{ $newdatetimetype }}
                                        بواسطه
                                        {{ $data['added_by_admin'] }}
                                    @else
                                        لا يوجد
                                    @endif
                                </td>

                            </tr>

                            <tr>
                                <td>تاريخ اخر تحديث </td>
                                <td>
                                    @if ($data['updated_by'] > 0 && $data['updated_by'] != null)
                                        @php
                                            $dt = new DateTime($data['updated_at']);
                                            $date = $dt->format('Y-m-d');
                                            $time = $dt->format('h-i');
                                            $newdatetime = date('A', strtotime($time));
                                            $newdatetimetype = $newdatetime == 'PM' ? 'صباحا' : 'مساء';
                                        @endphp
                                        {{ $date }}
                                        {{ $time }}
                                        {{ $newdatetimetype }}
                                        بواسطه
                                        {{ $data['updated_by_admin'] }}
                                    @else
                                        لا يوجد
                                    @endif
                                    <a href="{{ route('admin.treasuries.edit', $data->id) }}"
                                        class="btn btn-primary">تعديل</a>
                                </td>
                            </tr>

                        </table>
                        <br>
                    @else
                        <div class="alert alert-warning">
                            لا توجد بيانات
                        </div>
                    @endif

                    <div class="card-header">
                        <h3 class="card-title card_title_center"> الخزن المضافه لل ({{ $data['name'] }})</h3>
                    </div>
                    <button type="button" class="btn btn-primary m-2 addtreasuries" data-toggle="modal"
                        data-target="#addtreasuries">اضافه خزنه جديده
                    </button>


                    @if (isset($admin_treasuries) && count($admin_treasuries) > 0)
                        <table class="table table-bordered table-hover text-center">
                            <thead class="custom_head">
                                <tr>
                                    <th>التسلسل</th>
                                    <th>اسم الخزن</th>
                                    <th>تاريخ الاضافه </th>
                                    <th> </th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($admin_treasuries as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>

                                        <td>{{ $item->name }}</td>

                                        <td>
                                            @if ($item['created_at'] != null)
                                                @php
                                                    $dt = new DateTime($item['created_at']);
                                                    $date = $dt->format('Y-m-d');
                                                    $time = $dt->format('h-i');
                                                    $newdatetime = date('A', strtotime($time));
                                                    $newdatetimetype = $newdatetime == 'PM' ? 'صباحا' : 'مساء';
                                                @endphp
                                                {{ $date }}
                                                {{ $time }}
                                                {{ $newdatetimetype }}
                                                بواسطه
                                                {{ $data['added_by_admin'] }}
                                            @else
                                                لا يوجد
                                            @endif

                                        </td>
                                        <td>
                                            <form action="{{ route('admin_treasuries.deletetreasuries', $item->id) }}" method="POST"
                                                style="display:inline;" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger">
                                                    حذف
                                                </button>
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-warning">
                            لا توجد بيانات
                        </div>
                    @endif

                </div>

            </div>

            <div class="modal fade" id="addtreasuries">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content bg-info">
                        <div class="modal-header">
                            <h4 class="modal-title">الخزن</h4>
                            <button type="button" class="close color-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                        </div>

                        <input type="hidden" id="token_search" value="{{ csrf_token() }}">
                        <input type="hidden" id="admin_id" value="{{ $data->id }}">
                        <input type="hidden" id="ajax_addtreasuries" value="{{ route('admin_treasuries.addtreasuries') }}">                        <input type="hidden" id="ajax_edititem" value="{{ route('supplier_orders.edititem') }}">

                        <div class="modal-body" id="edit_item_model_body"
                            style="background-color: white !important; color: black;">

                            <div class="col-4">
                                <label for="admin_id">اسم الخزنه</label>
                                <select name="name" id="name" class="form-control">
                                    <option selected disabled value="">اختر الخزنه</option>
                                    @foreach ($treasuries as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="m-2 text-center">
                                <button type="button" class="btn btn-info" id="add">اضافه</button>
                            </div>



                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-outline-light" data-dismiss="modal">اغلاق</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/admin/js/admin_treasuries.js') }}"></script>
@endsection
