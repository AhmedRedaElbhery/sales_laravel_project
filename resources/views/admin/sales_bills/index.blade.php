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
                    <button type="button" class="btn btn-success edititem" data-toggle="modal" data-target="#modal_bill">اضافه
                        فاتوره جديده
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
                                        <th>الا </th>
                                        <th> </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $item->auto_serial }}</td>

                                            <td>{{ $item->customer_name }}</td>
                                            <td>
                                                @if ($item->doc_type == 1)
                                                    فاتوره مشتريات
                                                @elseif ($item->doc_type == 2)
                                                    فاتوره مرتحعات
                                                @else
                                                    فاتوره مشتريات
                                                @endif
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


                                                <a href="{{ route('sales_bills.show', $item->id) }}"
                                                    class="btn btn-info">التفاصيل</a>
                                                @if ($item->is_approved == 0)
                                                    <form action="{{ route('sales_bills.destroy', $item->id) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">حذف</button>
                                                    </form>
                                                @endif


                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <br>
                            <div class="mt-3">
                                {{ $data->links() }}
                            </div>
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

    <div class="modal fade" id="modal_bill">
        <div class="modal-dialog modal-xl">
            <div class="modal-content bg-info">

                <div class="modal-header">
                    <h4 class="modal-title"> اضافه فاتوره مبيعات</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <input type="hidden" id="token_search" value="{{ csrf_token() }}">
                <input type="hidden" id="autoserialparent" value="{{ $data['auto_serial'] }}">
                <input type="hidden" id="sales_item_getUnits_url" value="{{ route('sales_item.getUnits') }}">

                <div class="modal-body bg-white text-dark">

                    <div class="row">

                        <div class="form-group col-md-4">
                            <label>تاريخ الفاتوره</label>
                            <input type="date" class="form-control" id="invoice_date" value="">

                            @error('invoice_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label>حساب العميل
                                <a href="{{ route('customers.create') }}">اضافه عميل جديد</a>
                            </label>
                            <select class="form-control select2" id="customer_id">
                                <option value="" selected disabled>
                                    اختر حساب العميل
                                </option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>

                        </div>

                        <div class="form-group col-md-4">
                            <label>حساب المندوب</label>
                            <select class="form-control select2" id="_id">
                                <option value="" selected disabled>
                                    اختر حساب المندوب
                                </option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>

                        </div>

                        <div class="form-group col-md-4">
                            <label>الصنف</label>
                            <select class="form-control select2" id="item_code">
                                <option value="" selected disabled>
                                    اختر الصنف
                                </option>
                                @foreach ($items as $item)
                                    <option value="{{ $item->item_code }}">
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>

                        </div>



                        <div class="col-4 related_to_itemcard" style="display: none" id="unitsDiv">

                        </div>

                        <div class="form-group col-md-4">
                            <label>نوع البيع</label>
                            <select class="form-control" id="sale_type">
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
                            <input type="number" class="form-control" id="quantity" name="quantity">

                            @error('quantity')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-3">
                            <label>نوع المنتج </label>
                            <select class="form-control" id="normal_sale">
                                <option value="" selected disabled>اختر النوع</option>
                                <option value="0">بيع عادى</option>
                                <option value="1">بونص</option>
                                <option value="2">دعايه</option>
                            </select>

                            @error('price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div style="display: none" id="price_div" class="form-group col-md-3">
                            <label>السعر </label>
                            <input type="number" class="form-control" id="price" name="price">
                        </div>


                        <div class="form-group col-md-3">
                            <label>الاجمالى النهائى</label>
                            <input type="number" readonly name="total_value" id="total_value" class="form-control">

                            @error('total_value')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="col-12">

                            <div class="form-group text-center">
                                <button type="button" class="btn btn-info" id="approve_bill"> اضافه الفاتوره
                                </button>
                            </div>
                        </div>

                    </div>

                    <div class="row p-3">
                        <h4 class="form-control text-center">الاصناف المضافه للفاتوره</h4>
                        <table class="table table-bordered table-hover text-center">
                            <thead class="custom_head">
                                <tr>
                                    <th>تاريخ الفاتوره</th>
                                    <th>الصنف</th>
                                    <th>نوع البيع</th>
                                    <th>الكميه</th>
                                    <th>نوع المنتج</th>
                                    <th>سعر الوحده </th>
                                    <th>الاجمالى </th>
                                    <th> </th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($data as $item)
                                    <tr>

                                        <td>
                                            {{ $item->invoice_date }}

                                        </td>

                                        <td>
                                            <form action="{{ route('sales_bills.destroy', $item->id) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">حذف</button>
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br>
                        <div class="mt-3">
                            {{ $data->links() }}
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
