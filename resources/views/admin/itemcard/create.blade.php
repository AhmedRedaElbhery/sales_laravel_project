@extends('layouts.admin')

@section('title')
    إضافة صنف جديد
@endsection

@section('contentheader')
    الاصناف
@endsection

@section('contentheaderlink')
    <a href="{{ route('itemcard.index') }}"> الاصناف </a>
@endsection

@section('contentheaderactive')
    إضافة
@endsection

@section('content')
    <div class="card">

        <div class="card-header">
            <h3 class="card-title card_title_center">إضافة صنف جديد</h3>
        </div>

        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger text-center">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('itemcard.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div>
                    <div class="row mb-2">
                        <div class="form-group col-sm-6">
                            <label>باركود الصنف <span class="text-muted">(ف حاله عدم الادخال سيتم ادخاله اليا) </span>
                            </label>
                            <input type="text" name="barcode" class="form-control" value="{{ old('barcode') }}">
                            @error('barcode')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label>اسم الصنف </label>
                            <input type="text" name="name" class="form-control"  value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="row mb-2">
                        <div class="form-group col-sm-4">
                            <label>النوع </label>
                            <select name="item_type" class="form-control" >
                                <option value="" selected disabled>اختر النوع </option>
                                <option value="1" @selected(old('item_type') == '1')>تجزئه </option>
                                <option value="2" @selected(old('item_type') == '2')> استهلاكى بصلاحيه</option>
                                <option value="3" @selected(old('item_type') == '3')>عهده</option>
                            </select>
                            @error('item_type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-4">
                            <label>الفئه </label>
                            <select name="category_id" class="form-control" >
                                <option value="" selected disabled>اختر الفئه </option>

                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}" @selected(old('category_id') == $item->id)>{{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-4">
                            <label>وحده القياس الاساسيه للصنف </label>
                            <select name="unit_parent_id" id="unit_parent_id" class="form-control" >
                                <option value="" selected disabled>اختر الوحده </option>

                                @foreach ($units as $item)
                                    <option value="{{ $item->id }}" @selected(old('unit_parent_id') == $item->id)>{{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('unit_parent_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="row mb-2">
                        <div class="form-group col-sm-3 parent_divs"
                            @if (old('unit_parent_id') == '') style="display:none" @endif>
                            @php
                                $unitName = $units->where('id', old('unit_parent_id'))->first()?->name;
                            @endphp
                            <label>السعر الجمله لل (<span class="text-muted name_parent_unit">{{ $unitName }}
                                </span>) </label>
                            <input type="text"  name="Wholesale_price" class="form-control"
                                value="{{ old('Wholesale_price') }}">
                            @error('Wholesale_price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div
                            class="form-group col-sm-3 parent_divs"@if (old('unit_parent_id') == '') style="display:none" @endif>
                            <label>السعر النص جمله لل (<span class="name_parent_unit text-muted">
                                    {{ $unitName }}</span>) </label>
                            <input type="text" name="half_Wholesale_price" class="form-control"
                                value="{{ old('half_Wholesale_price') }}">
                            @error('half_Wholesale_price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div
                            class="form-group col-sm-3 parent_divs"@if (old('unit_parent_id') == '') style="display:none" @endif>
                            <label>السعر القطاعى لل (<span class="name_parent_unit text-muted">{{ $unitName }} </span>)
                            </label>
                            <input type="text" name="price" class="form-control"
                                value="{{ old('price') }}">
                            @error('price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div
                            class="form-group col-sm-3 parent_divs"@if (old('unit_parent_id') == '') style="display:none" @endif>
                            <label>السعر تكلفه الشراء لل (<span class="name_parent_unit text-muted">{{ $unitName }}
                                </span>)</label>
                            <input type="text" name="cost_price" class="form-control" value="{{ old('cost_price') }}">
                            @error('cost_price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group col-5">
                        <label>هل للصنف وحده تجزئه ؟</label>
                        <select name="has_retail_unit" id="retail_options" class="form-control" >
                            <option value="" selected disabled>اختر النوع </option>
                            <option value="1" @selected(old('has_retail_unit') == '1')>نعم </option>
                            <option value="0" @selected(old('has_retail_unit') == '0')> لا</option>
                        </select>
                        @error('has_retail_unit')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row mb-2">
                        <div class="form-group col-sm-4 retail_divs"
                            @if (old('has_retail_unit') != '1') style="display:none" @endif>
                            <label>وحده القياس التجزئه </label>
                            <select id="retail_unit_id" name="retail_units" class="form-control" >
                                <option value="" selected disabled>اختر الوحده </option>

                                @foreach ($retail_units as $item)
                                    <option value="{{ $item->id }}" @selected(old('retail_units') == $item->id)>{{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('retail_units')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-4 retail_divs"
                            @if (old('has_retail_unit') != '1') style="display:none" @endif>
                            @php
                                $retailName = $retail_units->where('id', old('retail_units'))->first()?->name;
                            @endphp
                            <label>عدد وحدات القياس التجزئه (<span class="name_retail_unit text-muted ">{{ $retailName }} </span>) لل (<span
                                    class="name_parent_unit text-muted ">{{ $unitName }} </span>)
                            </label>
                            <input type="text" name="retail_unit_to_parent" class="form-control"
                                value="{{ old('retail_unit_to_parent') }}">
                            @error('retail_unit_to_parent')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div
                            class="form-group col-sm-4 retail_divs"@if (old('has_retail_unit') != '1') style="display:none" @endif>
                            <label>السعر الجمله لل (<span class="name_retail_unit text-muted"> {{ $retailName }}</span>)</label>
                            <input type="text" name="retail_Wholesale_price" class="form-control"
                                value="{{ old('retail_Wholesale_price') }}">
                            @error('retail_Wholesale_price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="row mb-2">
                        <div
                            class="form-group col-sm-4 retail_divs"@if (old('has_retail_unit') != '1') style="display:none" @endif>
                            <label>السعر النص جمله لل (<span class="name_retail_unit text-muted"> {{ $retailName }}</span>)</label>
                            <input type="text" name="retail_half_Wholesale_price" class="form-control"
                                value="{{ old('retail_half_Wholesale_price') }}">
                            @error('retail_half_Wholesale_price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div
                            class="form-group col-sm-4 retail_divs"@if (old('has_retail_unit') != '1') style="display:none" @endif>
                            <label>السعر القطاعى لل (<span class="name_retail_unit text-muted">{{ $retailName }}</span>)</label>
                            <input type="text" name="retail_price" class="form-control"
                                value="{{ old('retail_price') }}">
                            @error('retail_price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div
                            class="form-group col-sm-4 retail_divs"@if (old('has_retail_unit') != '1') style="display:none" @endif>
                            <label>السعر تكلفه الشراء لل (<span class="name_retail_unit text-muted">{{ $retailName }}</span>)</label>
                            <input type="text" name="retail_cost_price" class="form-control"
                                value="{{ old('retail_cost_price') }}">
                            @error('retail_cost_price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-2">

                        <div
                            class="form-group col-sm-4 parent_divs"@if (old('unit_parent_id') == '') style="display:none" @endif>
                            <label> هل للصنف سعر ثابت؟ </label>
                            <select name="has_fixed_price" class="form-control" >
                                <option value="" selected disabled>اختر الحاله</option>
                                <option value="1">ثابت وغير قابل للتغير</option>
                                <option value="0">قابل للتغير بالفواتير</option>
                            </select>
                            @error('has_fixed_price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="row mb-2">
                        <div class="form-group col-sm-5">
                            <label>حالة التفعيل</label>
                            <select name="active" class="form-control" >
                                <option value="" selected disabled>اختر الحاله</option>
                                <option value="1" @selected(old('active') == '1')>مفعل</option>
                                <option value="0" @selected(old('active') == '0')>معطل</option>
                            </select>
                            @error('active')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-5 ml-5">
                            <label>صوره الصنف ان وجدت </label>

                            <input type="file" name="photo" class="form-control">

                            @error('photo')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                </div>

                <button type="submit" class="btn btn-primary m-5 p-2 col-sm-5">
                    حفظ
                </button>

                <a href="{{ route('itemcard.index') }}" class="btn btn-secondary m-4 p-2 col-sm-5">
                    رجوع
                </a>

            </form>

        </div>

    </div>
    </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            $('#retail_options').change(function() {

                if ($(this).val() == 1) {
                    $('.retail_divs').css('display', 'block');
                } else {
                    $('.retail_divs').css('display', 'none');
                }

            });

            $('#unit_parent_id').change(function() {

                let text = $(this).find('option:selected').text();

                $('.name_parent_unit').text(text);

                if ($(this).val() != '') {
                    $('.parent_divs').css('display', 'block');
                } else {
                    $('.parent_divs').css('display', 'none');
                }


            });

            $('#retail_unit_id').change(function() {

                let text = $(this).find('option:selected').text();
                $('.name_retail_unit').text(text);

            });

        });
    </script>
@endsection
