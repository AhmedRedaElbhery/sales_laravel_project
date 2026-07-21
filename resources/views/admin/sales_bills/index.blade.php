@extends('layouts.admin');

@section('title')
    المبيعات
@endsection

@section('contentheader')
    حركات مخزنيه
@endsection

@section('contentheaderlink')
    <a href="{{ route('sales_bills.index') }}"> فواتير المبيعات </a>
@endsection


@section('contentheaderactive')
    عرض
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title card_title_center">فواتير المبيعات للعملاء </h3>
                    <button type="button" class="btn btn-primary edititem" data-toggle="modal" data-target="#modal_mirrorbill">
                        فاتوره عرض اسعار
                    </button>
                    <button type="button" class="btn btn-success edititem" data-toggle="modal"
                        data-target="#modal_activebill"> اضافه
                        فاتوره فعليه
                    </button>
                </div>

                <div class="card-body">

                    @if (isset($data) && count($data) > 0)
                        <div id="ajax_responce_searchDiv">

                            <table class="table table-bordered table-hover text-center">
                                <thead class="custom_head">
                                    <tr>
                                        <th>كود الفاتوره</th>
                                        <th>اسم العميل</th>
                                        <th>نوع البيع</th>
                                        <th>تاريخ الفاتوره</th>
                                        <th>حاله الاعتماد </th>
                                        <th> </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $item->auto_serial }}</td>

                                            <td>{{ $item->customer_name }}</td>
                                            <td>

                                            </td>

                                            <td>
                                                {{ $item->invoice_date }}

                                            </td>

                                            <td>
                                                @if ($item->is_approved == 0)
                                                    <span class="badge badge-danger p-2">غير معتمده</span>
                                                @else
                                                    <span class="badge badge-success p-2">معتمده</span>
                                                @endif
                                            </td>

                                            <td>

                                                <input type="hidden" id="get_active_bill_data_url" value="{{ route('sales_item.get_active_bill_data') }}" />
                                                <button data-autoserial="{{ $item->auto_serial }}"
                                                   class="btn btn-info edit_bill">تعديل</button>

                                                <button data-autoserial="{{ $item->auto_serial }}"
                                                     class="btn btn-danger delete_bill">حذف</button>

                                            </td>
                                        </tr>
                                    @endforeach
                                    <br>
                                    <div class="mt-3">
                                        {{ $data->links() }}
                                    </div>
                                </tbody>

                            </table>

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

    <div class="modal fade" id="modal_mirrorbill">
        <div class="modal-dialog modal-xl">
            <div class="modal-content bg-info">

                <div class="modal-header">
                    <h4 class="modal-title"> فاتوره عرض اسعار</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <input type="hidden" id="token_search" value="{{ csrf_token() }}">
                <input type="hidden" id="autoserialparent" value="{{ $data['auto_serial'] }}">
                <input type="hidden" id="sales_item_getUnits_url" value="{{ route('sales_item.getUnits') }}">
                <input type="hidden" id="sales_item_get_batches_url" value="{{ route('sales_item.get_batches') }}">
                <input type="hidden" id="sales_item_getprice_url" value="{{ route('sales_item.get_price') }}">
                <input type="hidden" id="sales_item_getitems_url" value="{{ route('sales_item.get_add_items') }}">

                <div class="modal-body bg-white text-dark">

                    <div class="row p-3" style="border: 1px solid blue">


                        {{-- <div class="form-group col-md-4">
                            <label>المخزن</label>
                            <select class="form-control select2" id="mirror_store_id">
                                <option value="" selected disabled>
                                    اختر المخزن
                                </option>
                                @foreach ($stores as $store)
                                    <option value="{{ $store->id }}">
                                        {{ $store->name }}
                                    </option>
                                @endforeach
                            </select>

                        </div> --}}

                        <div class="form-group col-md-4">
                            <label>الصنف</label>
                            <select class="form-control select2" id="mirror_item_code">
                                <option value="" selected disabled>
                                    اختر الصنف
                                </option>
                                @foreach ($items as $item)
                                    <option data-type="{{ $item->item_type }}" value="{{ $item->item_code }}">
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>



                        <div class="col-4 related_to_itemcard" style="display: none" id="mirror_unitsDiv">

                        </div>


                        <div class="col-4 batches" style="display: none" id="mirror_batches_div">

                        </div>

                        <div class="form-group col-md-4">
                            <label>نوع البيع</label>
                            <select class="form-control" id="mirror_sale_type">
                                <option value="" selected disabled>
                                    اختر طريقه البيع
                                </option>
                                <option value="0">
                                    جمله
                                </option>
                                <option value="1">
                                    نص جمله
                                </option>
                                <option value="2">
                                    قطاعى
                                </option>
                            </select>

                        </div>

                        <div class="form-group col-md-3">
                            <label>الكميه </label>
                            <input type="number" value="" class="form-control" id="mirror_quantity" name="quantity">

                            @error('quantity')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div style="display: none" id="mirror_price_div" class="form-group col-md-3">
                            <label>السعر </label>
                            <input readonly type="number" value="" class="form-control" id="mirror_price"
                                name="price">
                        </div>


                        <div class="form-group col-md-3">
                            <label>الاجمالى النهائى</label>
                            <input type="number" value="" readonly name="total_price" id="mirror_total_price"
                                class="form-control">

                            @error('total_price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="col-12">

                            <div class="form-group text-center">
                                <button type="button" class="btn btn-info" id="mirror_save_item"> اضافه الفاتوره
                                </button>
                            </div>
                        </div>

                    </div>

                    <div class="row p-3 " style="border: 1px solid blue">
                        <h4 class="form-control text-center">الاصناف المضافه للفاتوره</h4>
                        <table class="table table-bordered table-hover text-center">
                            <thead class="custom_head">
                                <tr>
                                    <th>الصنف</th>
                                    <th>وحده الصنف</th>
                                    <th>نوع البيع</th>
                                    <th>الكميه</th>
                                    <th>نوع المنتج</th>
                                    <th>سعر الوحده </th>
                                    <th>الاجمالى </th>
                                    <th> </th>
                                </tr>
                            </thead>

                            <tbody id="mirror_items_table">

                            </tbody>
                        </table>
                    </div>

                    <div class="row p-3" style="border: 1px solid blue">

                        <div class="form-group col-md-4">
                            <label>الاجمالى بالفاتوره قبل الخصم والضريبه</label>
                            <input class="form-control" readonly id="mirror_total" value="{{ 0 / 100 }}">


                        </div>

                        <div class="form-group col-md-4">
                            <label>ادخل نسبه الضريبه على الفاتوره</label>
                            <input type="number" name="tax_percent" value="" id="mirror_tax_percent"
                                class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                            <label> قيمه الضريبه </label>
                            <input type="number" readonly name="tax_value" value="" id="mirror_tax_value"
                                class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                            <label>ادخل نسبه الخصم على الفاتوره</label>
                            <input type="number" name="discount_percent" value="" id="mirror_discount_percent"
                                class="form-control">


                        </div>

                        <div class="form-group col-md-4">
                            <label>قيمه الخصم </label>
                            <input type="number" readonly name="discount_value" value=""
                                id="mirror_discount_value" class="form-control">

                        </div>

                        <div class="form-group col-md-4">
                            <label>الاجمالى النهائى</label>
                            <input type="number" readonly name="total_value" value="" id="mirror_total_value"
                                class="form-control">
                        </div>

                    </div>

                    <div class="text-center">
                        <button type="button" class="btn btn-primary mt-3 p-2 ">
                            طباعه الاسعار
                        </button>

                    </div>

                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">
                        اغلاق
                    </button>
                </div>

            </div>

        </div>

    </div>

    <div class="modal fade" id="modal_activebill">
        <div class="modal-dialog modal-xl">
            <div class="modal-content bg-info">

                <div class="modal-header">
                    <h4 class="modal-title"> فاتوره مبيعات</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <input type="hidden" id="token_search" value="{{ csrf_token() }}">
                <input type="hidden" id="autoserialparent" value="{{ $data['auto_serial'] }}">
                <input type="hidden" id="sales_item_getUnits_url" value="{{ route('sales_item.getUnits') }}">
                <input type="hidden" id="sales_item_get_batches_url" value="{{ route('sales_item.get_batches') }}">
                <input type="hidden" id="sales_item_getprice_url" value="{{ route('sales_item.get_price') }}">
                <input type="hidden" id="sales_item_getitems_url" value="{{ route('sales_item.get_add_items') }}">




                <input type="hidden" id="open_active_bill" value="{{ route('sales_item.open_active_bill') }}">




                <div class="modal-body bg-white text-dark">

                    <div class="row p-3" style="border: 1px solid blue">

                        <div class="form-group col-md-3">
                            <label>تاريخ الفاتوره</label>
                            <input type="date" class="form-control" id="invoice_date" value="">

                            @error('invoice_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-3">
                            <label>انواع فئات الفواتير
                            </label>
                            <select class="form-control select2" id="sales_material_type">
                                <option value="" selected disabled>
                                    اختر نوع فئه الفاتوره
                                </option>
                                @foreach ($sales_material_types as $sales_material_type)
                                    <option value="{{ $sales_material_type->id }}">
                                        {{ $sales_material_type->name }}
                                    </option>
                                @endforeach
                            </select>

                        </div>

                        <div class="form-group col-md-3">
                            <label>حساب العميل
                                <a href="{{ route('customers.create') }}">اضافه عميل جديد</a>
                            </label>
                            <select class="form-control select2" id="customer_code">
                                <option value="" selected disabled>
                                    اختر حساب العميل
                                </option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->customer_code }}">
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>

                        </div>

                        <div class="form-group col-md-3">
                            <label>حساب المندوب</label>
                            <select class="form-control select2" id="delegate_code">
                                <option value="" selected disabled>
                                    اختر حساب المندوب
                                </option>
                                @foreach ($delegates as $delegate)
                                    <option value="{{ $delegate->delegate_code }}">
                                        {{ $delegate->name }}
                                    </option>
                                @endforeach
                            </select>

                        </div>

                        <div class="col-12 mt-3">
                            <div class="form-group text-center">
                                <button type="button" id="open_active_bill" class="btn btn-primary p-2">
                                    اضافه الفاتوره
                                </button>

                            </div>
                        </div>

                    </div>

                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">
                        اغلاق
                    </button>
                </div>

            </div>

        </div>

    </div>

    <div class="modal fade" id="modal_billitems">

    </div>

    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%',
            });
            $('.select2-selection').height(24);
            $('.select2-selection__rendered').css('line-height', '24px');
            $('.select2-selection__arrow').height(24);
        });
    </script>
    <script src="{{ asset('assets/admin/js/sales_bills.js') }}"></script>
@endsection
