<div class="modal-dialog modal-xl">
    <div class="modal-content bg-info">

        <div class="modal-header">
            <h4 class="modal-title">اضافه اصناف لفاتوره مبيعات</h4>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <input type="hidden" id="token_search" value="{{ csrf_token() }}">
        <input type="hidden" id="autoserial" value="{{ $data['auto_serial'] }}">

        <input type="hidden" id="save_active_billitems_url" value="{{ route('sales_item.save_active_billitems') }}">
        <input type="hidden" id="active_add_items_url" value="{{ route('sales_item.active_add_items') }}">




        <div class="modal-body bg-white text-dark">

            <div class="row p-3" style="border: 1px solid blue">

                <div class="form-group col-md-3">
                    <label>تاريخ الفاتوره</label>
                    <input type="date" class="form-control" id="update_invoice_date" value="{{ $data->invoice_date }}">

                    @error('invoice_date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label>انواع فئات الفواتير
                    </label>
                    <select class="form-control select2" id="update_sales_material_type">
                        <option value="" selected disabled>
                            اختر نوع فئه الفاتوره
                        </option>
                        @foreach ($sales_material_types as $sales_material_type)
                            <option value="{{ $sales_material_type->id }}" @if ($data->sales_material_type_id == $sales_material_type->id )
                                selected
                            @endif>
                                {{ $sales_material_type->name }}
                            </option>
                        @endforeach
                    </select>

                </div>

                <div class="form-group col-md-3">
                    <label>حساب العميل
                        <a href="{{ route('customers.create') }}">اضافه عميل جديد</a>
                    </label>
                    <select class="form-control select2" id="update_customer_code">
                        <option value="" selected disabled>
                            اختر حساب العميل
                        </option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->customer_code }}" @if ($data->customer_code == $customer->customer_code )
                                selected
                            @endif>
                                {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>

                </div>

                <div class="form-group col-md-3">
                    <label>حساب المندوب</label>
                    <select class="form-control select2" id="update_delegate_code">
                        <option value="" selected disabled>
                            اختر حساب المندوب
                        </option>
                        @foreach ($delegates as $delegate)
                            <option value="{{ $delegate->delegate_code }}" @if ($data->delegate_code == $delegate->delegate_code )
                                selected
                            @endif>
                                {{ $delegate->name }}
                            </option>
                        @endforeach
                    </select>

                </div>

            </div>


            <div class="row p-3" style="border: 1px solid blue">

                <div class="form-group col-md-3">
                    <label>نوع المنتج </label>
                    <select class="form-control" id="normal_sale">
                        <option value="" selected disabled>اختر النوع</option>
                        <option value="0">بيع عادى</option>
                        <option value="1">بونص</option>
                        <option value="2">دعايه</option>
                    </select>
                </div>


                <div class="form-group col-md-4">
                    <label>المخزن</label>
                    <select class="form-control select2" id="store_id">
                        <option value="" selected disabled>
                            اختر المخزن
                        </option>
                        @foreach ($stores as $store)
                            <option value="{{ $store->id }}">
                                {{ $store->name }}
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
                            <option data-type="{{ $item->item_type }}" value="{{ $item->item_code }}">
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>

                </div>



                <div class="col-4 related_itemcard" style="display: none" id="unitsDiv">

                </div>


                <div class="col-4 batches" style="display: none" id="batches_div">

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
                    <input type="number" value="" class="form-control" id="quantity" name="quantity">

                    @error('quantity')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div style="display: none" id="price_div" class="form-group col-md-3">
                    <label>السعر </label>
                    <input readonly type="number" value="" class="form-control" id="price" name="price">
                </div>


                <div class="form-group col-md-3">
                    <label>الاجمالى النهائى</label>
                    <input type="number" value="" readonly name="total_price" id="total_price"
                        class="form-control">

                    @error('total_price')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="col-12">

                    <div class="form-group text-center">
                        <button type="button" class="btn btn-info" id="save_edit_item"> اضافه الفاتوره
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

                    <tbody id="table_items">

                    </tbody>
                </table>
            </div>

            <div class="row p-3" style="border: 1px solid blue">

                <div class="form-group col-md-4">
                    <label>الاجمالى بالفاتوره قبل الخصم والضريبه</label>
                    <input class="form-control" readonly id="total" value="{{ 0 / 100 }}">


                </div>

                <div class="form-group col-md-4">
                    <label>ادخل نسبه الضريبه على الفاتوره</label>
                    <input type="number" name="tax_percent" value="" id="tax_percent" class="form-control">
                </div>

                <div class="form-group col-md-4">
                    <label> قيمه الضريبه </label>
                    <input type="number" readonly name="tax_value" value="" id="tax_value"
                        class="form-control">
                </div>

                <div class="form-group col-md-4">
                    <label>ادخل نسبه الخصم على الفاتوره</label>
                    <input type="number" name="discount_percent" value="" id="discount_percent"
                        class="form-control">


                </div>

                <div class="form-group col-md-4">
                    <label>قيمه الخصم </label>
                    <input type="number" readonly name="discount_value" value="" id="discount_value"
                        class="form-control">

                </div>

                <div class="form-group col-md-4">
                    <label>الاجمالى النهائى</label>
                    <input type="number" readonly name="total_value" value="" id="total_value"
                        class="form-control">


                </div>

                <div class="form-group col-md-4">
                    <label>نوع الفاتوره</label>
                    <select class="form-control" id="bill_type">

                        <option value="" selected disabled>
                            اختر نوع الفاتوره
                        </option>

                        <option value="0">
                            كاش
                        </option>

                        <option value="1">
                            اجل
                        </option>
                    </select>


                </div>

                <div class="form-group col-md-4">
                    <label>الخزنة الحالية</label>
                    <select class="form-control" id="treasuries_id" disabled>
                        <option value="{{ $shift->treasuries_id }}" selected>
                            {{ $shift->treasuries_name }}
                        </option>
                    </select>


                </div>

                <div class="form-group col-md-4">
                    <label>الرصيد المتاح بالخزنه</label>
                    <input class="form-control" readonly id="treasuries_balance"
                        value="{{ $shift->treasuries_balance }}">
                </div>


                <div class="form-group col-md-4">
                    <label>المبلغ المدفوع </label>
                    <input class="form-control" value="" id="what_paid" name="what_paid">


                </div>

                <div class="form-group col-md-4">
                    <label>المبلغ المتبقى </label>
                    <input readonly class="form-control" value="" id="what_remain" name="what_remain">


                </div>

                <div class="form-group col-md-4">
                    <label>الملاحظات </label><br>
                    <textarea class="m-1" style="width: 320px"></textarea>
                </div>

            </div>

            <div class="col-12">
                <div class="form-group text-center">
                    <button type="button" class="btn btn-success p-2 mt-3" style="width: 100px">
                        اعتماد
                    </button>
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
