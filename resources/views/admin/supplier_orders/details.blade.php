@extends('layouts.admin');

@section('title')
    المشتريات
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('contentheader')
    حركات مخزنيه
@endsection

@section('contentheaderlink')
    <a href="{{ route('supplier_orders.index') }}"> فواتير المشتريات </a>
@endsection


@section('contentheaderactive')
    عرض
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title card_title_center">بيانات فاتوره المشتريات</h3>
                </div>

                <div class="card-body">
                    @if (isset($data))
                        <table id="example2" class="table table-bordered table-hover">
                            <tr>
                                <td class="width30">كود الفاتوره الالى</td>
                                <td>{{ $data['auto_serial'] }}</td>
                            </tr>

                            <tr>
                                <td class="width30">كود الفاتوره لدى المورد</td>
                                <td>{{ $data['doc_number'] }}</td>
                            </tr>

                            <tr>
                                <td class="width30">تاريخ الفاتوره</td>
                                <td>{{ $data['order_date'] }}</td>
                            </tr>

                            <tr>
                                <td class="width30">اسم المورد</td>
                                <td>{{ $data['supplier_name'] }}</td>
                            </tr>

                            <tr>
                                <td>نوع الفاتوره</td>
                                <td>
                                    @if ($data['pill_type'] == 0)
                                        كاش
                                    @else
                                        اجل
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td class="width30">اجمالى الفاتوره قبل الخصم</td>
                                <td>{{ $data['total_before_discount'] /100 }}</td>
                            </tr>

                            @if ($data['descpunt_type'] != null)
                                <tr>
                                    <td class="width30">نوع الخصم على الفاتوره</td>

                                    @if ($data['discount_type'] == 1)
                                        <td>خصم نسبه {{ $data['discount_percent'] }} وقيمتها
                                            {{ $data['discount_value'] }}</td>
                                    @else
                                        <td>خصم يدوى وقيمته {{ $data['discount_value'] }}</td>
                                    @endif
                                </tr>
                            @else
                                <tr>
                                    <td class="width30">الخصم على الفاتوره</td>
                                    <td>لا يوجد خصم</td>
                                </tr>
                            @endif


                            <tr>
                                <td class="width30"> الضرايب</td>
                                @if ($data['tax_percent'] == 0 || $data['tax_percent'] == null)
                                    <td> لا يوجد</td>
                                @else
                                    <td>نسبه الضرايب{{ $data['tax_percent'] }} وقيمتها {{ $data['tax_value'] }}</td>
                                @endif
                            </tr>

                            <tr>
                                <td class="width30">اجمالى الفاتوره بعد الخصم</td>
                                <td>{{ $data['total_cost'] /100 }}</td>
                            </tr>

                            <tr>
                                <td class="width30">المخزن</td>
                                <td>{{ $data['store_name'] }}</td>
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

                                </td>
                            </tr>
                            <tr>
                                <td>
                                    @if ($data['is_approved'] == 0)
                                        <a href="#" class="btn btn-primary text-white" style="width: 100%; height: 100%;">تعديل</a>
                                    @endif
                                </td>
                            </tr>
                        </table>

                        @if ($data['is_approved'] == 0)
                            <button type="button" class="btn btn-info m-2" data-toggle="modal"
                                data-target="#add_item_model">
                                اضافه صنف للفاتوره
                            </button>
                        @endif

                        <br>
                    @else
                        <div class="alert alert-warning">
                            لا توجد بيانات
                        </div>
                    @endif

                    @if (isset($details) && count($details) > 0)
                        <div class="card-header">
                            <h3 class="card-title card_title_center">الاصناف المضافه لهذه الفاتوره</h3>
                        </div>
                        <table class="table table-bordered table-hover text-center">
                            <thead class="custom_head">
                                <tr>
                                    <th>التسلسل</th>
                                    <th>اسم الصنف</th>
                                    <th>وحده الصنف</th>
                                    <th>سعر وحده الصنف</th>
                                    <th>الكميه</th>
                                    <th>الاجمالى</th>
                                    <th>تاريخ الانتاج </th>
                                    <th>تاريخ انتهاء الصلاحيه </th>
                                    @if ($data['is_approved'] == 0)
                                        <th> </th>
                                    @endif
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($details as $bill_item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>

                                        <td>{{ $bill_item->item_name }}</td>
                                        <td>{{ $bill_item->unit_name }}</td>
                                        <td>{{ $bill_item->unit_price / 100 }}</td>
                                        <td>{{ $bill_item->delivered_quantity * 1 }}</td>
                                        <td>{{ $bill_item->total_price / 100 }}</td>
                                        <td>{{ $bill_item->production_date }}</td>
                                        <td>{{ $bill_item->end_date }}</td>

                                        @if ($data['is_approved'] == 0)
                                            <td>
                                                <a href="#" class="btn btn-primary text-white">تعديل</a>
                                                <form
                                                    action="{{ route('supplier_orders.destroy_details', $bill_item->id) }}"
                                                    method="POST" style="display:inline;"
                                                    onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-danger">
                                                        حذف
                                                    </button>
                                                </form>

                                            </td>
                                        @endif

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
        </div>

        <div class="modal fade" id="add_item_model">
            <div class="modal-dialog modal-xl">
                <div class="modal-content bg-info">
                    <div class="modal-header">
                        <h4 class="modal-title">اضافه اصناف للفاتوره</h4>
                        <button type="button" class="close color-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                    </div>

                    <input type="hidden" id="token_search" value="{{ csrf_token() }}">
                    <input type="hidden" id="autoserialparent" value="{{ $data['auto_serial'] }}">
                    <input type="hidden" id="ajax_getUnits_url" value="{{ route('supplier_orders.getUnits') }}">
                    <input type="hidden" id="ajax_addunits" value="{{ route('supplier_orders.addunits') }}">

                    <div class="modal-body" id="model_body" style="background-color: white !important; color: black;">
                        <div class="row">

                            <div class="col-4">
                                <div class="form-group">
                                    <label>بيانات الاصناف </label>
                                    <select id="item_card_add" name="items" class="form-control select2">
                                        <option value="" selected disabled>اختر اسم الصنف</option>

                                        @if (isset($items))
                                            @foreach ($items as $item)
                                                <option data-type="{{ $item->item_type }}" value="{{ $item->item_code }}">
                                                    {{ $item->name }}</option>
                                            @endforeach
                                        @endif

                                    </select>
                                    @error('items')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-4 related_to_itemcard" style="display: none" id="unitsDiv">

                            </div>

                            <div class="col-4 related_to_itemcard" style="display: none">

                                <div class="form-group">
                                    <label>الكميه المستلمه</label>
                                    <input type="number" id="quantity_add" name="quantity_add" class="form-control"
                                        value="">

                                </div>
                            </div>

                            <div class="col-4 related_to_itemcard" style="display: none">

                                <div class="form-group">
                                    <label>سعر الوحده </label>
                                    <input type="number" id="price_add" name="price_add" class="form-control"
                                        value="">

                                </div>
                            </div>

                            <div class="col-4 related_to_date" style="display: none">

                                <div class="form-group">
                                    <label>تاريخ الانتاج </label>
                                    <input type="date" id="production_date" name="production_date"
                                        class="form-control" value="">

                                </div>
                            </div>

                            <div class="col-4 related_to_date" style="display: none">

                                <div class="form-group">
                                    <label>تاريخ الانتهاء </label>
                                    <input type="date" id="end_date" name="end_date" class="form-control"
                                        value="">

                                </div>
                            </div>

                            <div class="col-4 related_to_itemcard" style="display: none">

                                <div class="form-group">
                                    <label>الاجمالى </label>
                                    <input readonly type="number" id="total_price" name="total_price"
                                        class="form-control" value="">

                                </div>
                            </div>

                            <div class="col-12">

                                <div class="form-group text-center">
                                    <button type="button" class="btn btn-info" id="addtobill">اضافه الاصناف
                                        للفاتوره</button>
                                </div>
                            </div>



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
@endsection

@section('script')
    <script src="{{ asset('assets/admin/js/supplier_orders.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function() {
            $('.select2').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
@endsection
