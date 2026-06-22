@extends('layouts.admin');

@section('title')
    الاصناف
@endsection

@section('contentheader')
    الاصناف
@endsection

@section('contentheaderlink')
    <a href="{{ route('itemcard.index') }}"> الاصناف </a>
@endsection


@section('contentheaderactive')
    عرض
@endsection


@section('content')
    <div class="card">

        <div class="card-header">
            <h3 class="card-title card_title_center">عرض الصنف</h3>
        </div>

        <div class="card-body border border-dark">

            <div>
                <div class="row mb-2">
                    <div class="form-group col-sm-6">
                        <label> - باركود الصنف : </label>
                        <td> {{ $data->barcode }} </td>
                    </div>

                    <div class="form-group col-sm-6">
                        <label> - اسم الصنف : </label>
                        <td> {{ $data->name }} </td>
                    </div>
                </div>


                <div class="row mb-2">

                    <div class="form-group col-sm-6">
                        <label> - النوع : </label>
                        <tr>
                            @if ($data->item_type == 1)
                                تجزئه
                            @elseif ($data->item_type == 2)
                                استهلاكى بصلاحيه
                            @elseif($data->item_type == 3)
                                عهده
                            @endif
                        </tr>
                    </div>

                    <div class="form-group col-sm-6">
                        <label class="ml-1"> - الفئه : </label>
                        <tr>{{ $data->category->name }}
                        </tr>
                    </div>
                </div>


                <div class="row mb-2">

                    <div class="form-group col-sm-6">
                        <label class="ml-1"> - الصنف الاساسى له : </label>
                        <tr>
                            @if ($data->parent_id == 0)
                                الصنف اساسى
                            @else
                                {{ $data->items->name }}
                            @endif

                        </tr>
                    </div>

                    <div class="form-group col-sm-6">
                        <label> - وحده القياس الاساسيه للصنف : </label>
                        <tr>
                            {{ $data->units->name }}
                        </tr>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="form-group col-sm-6">

                        <label> - السعر الجمله لل(<span class="text-muted name_parent_unit">{{ $data->units->name }}
                            </span>) : </label>
                        <td>{{ $data->Wholesale_price / 100 }} </td>
                    </div>

                    <div class="form-group col-sm-6">
                        <label> - السعر النص جمله لل(<span class="name_parent_unit text-muted">
                                {{ $data->units->name }}</span>) :</label>
                        <td>{{ $data->half_Wholesale_price / 100 }} </td>
                    </div>
                </div>

                <div class="row mb-2">

                    <div class="form-group col-sm-6">
                        <label> - السعر القطاعى لل (<span class="name_parent_unit text-muted">{{ $data->units->name }}
                            </span>)
                            : </label>
                        <td>{{ $data->price / 100 }} </td>

                    </div>

                    <div class="form-group col-sm-6">
                        <label> - السعر تكلفه الشراء لل(<span class="name_parent_unit text-muted">{{ $data->units->name }}
                            </span>) :</label>
                        <td>{{ $data->cost_price / 100 }} </td>
                    </div>
                </div>


                <div class="form-group col-5 mt-3 mb-4">
                    <label> - هل للصنف وحده تجزئه؟ :</label>
                    <td name="has_retail_unit" id="retail_options" class="form-control">
                        @if ($data->has_retail_unit == 1)
                            نعم
                        @elseif($data->has_retail_unit == 0)
                            لا
                        @endif
                    </td>
                </div>
                @if ($data->has_retail_unit == '1')
                <div class="row mb-2">

                    <div class="form-group col-sm-6 retail_divs"
                        @if ($data->has_retail_unit != '1') style="display:none" @endif>
                        <label> - وحده القياس التجزئه :</label>
                        <td>

                                {{ $data->retail_units->name }}
                        </td>
                    </div>

                    <div class="form-group col-sm-6 retail_divs"
                        @if ($data->has_retail_unit != '1') style="display:none" @endif>

                        <label> - عدد وحدات القياس التجزئه (<span
                                class="name_retail_unit text-muted ">{{ $data->retail_units->name }}
                            </span>) لل (<span class="name_parent_unit text-muted ">{{ $data->units->name }} </span>)
                            :</label>
                        <td> {{ $data->retail_unit_to_parent }} </td>
                    </div>
                </div>


                <div class="row mb-2">

                    <div
                        class="form-group col-sm-6 retail_divs"@if ($data->has_retail_unit != '1') style="display:none" @endif>
                        <label> - السعر الجمله لل (<span class="name_retail_unit text-muted">
                                {{ $data->retail_units->name }}</span>) :</label>
                        <td> {{ $data->retail_Wholesale_price / 100 }} </td>
                    </div>


                    <div
                        class="form-group col-sm-6 retail_divs"@if ($data->has_retail_unit != '1') style="display:none" @endif>
                        <label> - السعر النص جمله لل (<span class="name_retail_unit text-muted">
                                {{ $data->retail_units->name }}</span>) :</label>
                        <td> {{ $data->retail_half_Wholesale_price / 100}} </td>
                    </div>
                </div>

                <div class="row mb-2">

                    <div
                        class="form-group col-sm-6 retail_divs"@if ($data->has_retail_unit != '1') style="display:none" @endif>
                        <label> - السعر القطاعى لل (<span
                                class="name_retail_unit text-muted">{{ $data->retail_units->name }}</span>)
                            :</label>
                        <td> {{ $data->retail_price / 100}} </td>
                    </div>

                    <div
                        class="form-group col-sm-6 retail_divs"@if ($data->has_retail_unit != '1') style="display:none" @endif>
                        <label> - السعر تكلفه الشراء لل (<span
                                class="name_retail_unit text-muted">{{ $data->retail_units->name }}</span>)
                            :</label>
                        <td> {{ $data->retail_cost_price/ 100 }} </td>
                    </div>
                </div>
@endif
                <div class="row mb-2">

                    <div class="form-group col-sm-6 ">
                        <label> - هل للصنف سعر ثابت؟ :</label>
                        <td>
                            @if ($data->has_fixed_price == 1)
                                ثابت وغير قابل للتغير
                            @elseif($data->has_fixed_price == 0)
                                قابل للتغير بالفواتير
                            @endif
                        </td>
                    </div>

                    <div class="form-group col-sm-6">
                        <label> - حالة التفعيل :</label>
                        <td>
                            @if ($data->active == 1)
                                مفعل
                            @elseif($data->active == 0)
                                معطل
                            @endif
                        </td>
                    </div>

                </div>

                <div class="row mb-2">

                    <div class="form-group col-sm-8 ml-5">
                        <label> - صوره الصنف ان وجدت : </label>
                        <td>
                            @if (!empty($data->photo))
                                <img id="img" src="{{ asset('assets/admin/uploads/' . $data->photo) }}"
                                    alt="Item Photo" width="200" class="m-4">
                            @endif
                        </td>
                    </div>
                </div>


            </div>


            <a href="{{ route('itemcard.index') }}" class="btn btn-secondary m-4 p-2 col-sm-11">
                رجوع
            </a>

        </div>

    </div>
    </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            $('#delete_image').click(function() {
                $('#img').hide();
                $('#delete_photo').val('1');
            });

            $('#retail_options').change(function() {

                if ($(this).val() == 1) {
                    $('.retail_divs').css('display', 'block');
                } else {
                    $('.retail_divs').css('display', 'none');
                }

            });

            $('#retail_unit_id').change(function() {

                let text = $(this).find('option:selected').text();
                $('.name_retail_unit').text(text);

            });

        });
    </script>
@endsection
