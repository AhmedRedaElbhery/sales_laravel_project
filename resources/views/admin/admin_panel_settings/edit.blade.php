@extends('layouts.admin');

@section('title')
    تعديل الضبط العام
@endsection

@section('contentheader')
    الضبط
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin.adminpanelsettings.index') }}"> الضبط </a>
@endsection


@section('contentheaderactive')
    نعديل
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">تعديل بيانات الضبط العام</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if (@isset($data) && !@empty($data))
                        <form action="{{ route('admin.adminpanelsettings.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label>اسم الشركه</label>
                                <input type="text" name="system_name" class="form-control"
                                    value="{{ $data['system_name'] }}" required>
                                @error('system_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label>عنوان الشركه</label>
                                <input type="text" name="address" class="form-control" value="{{ $data['address'] }}">
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label>هاتف الشركه</label>
                                <input type="text" name="phone" class="form-control" value="{{ $data['phone'] }}">
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>الحساب الاساسى للعملاء  </label>
                                <select name="customer_parent_account_number" class="form-control" >

                                    <option value="" selected disabled>اختر الحساب  </option>

                                    @foreach ($accounts as $item)
                                        <option value="{{ $item->id }}" @if($item->id == $data['customer_parent_account_number'] ) selected
                                        @endif  @selected(old('customer_parent_account_number') == $item->id)>{{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('customer_parent_account_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>الحساب الاساسى للموردين  </label>
                                <select name="supplier_parent_account_number" class="form-control" >

                                    <option value="" selected disabled>اختر الحساب  </option>

                                    @foreach ($accounts as $item)
                                        <option value="{{ $item->id }}" @if($item->id == $data['supplier_parent_account_number'] ) selected
                                        @endif  @selected(old('supplier_parent_account_number') == $item->id)>{{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('supplier_parent_account_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label>رساله التنبيه اعلى الشاشه للشركه</label>
                                <textarea name="general_alert" class="form-control" rows="4">{{ $data['general_alert'] }}</textarea>
                                @error('general_alert')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label>لوجو الشركه</label>

                                <div class="mb-2">
                                    <img class="custom_img" src="{{ asset('assets/admin/uploads/' . $data['photo']) }}"
                                        alt="image not found">

                                </div>

                                <input type="file" name="photo" class="form-control">
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success">
                                    حفظ التعديلات
                                </button>
                            </div>
                        </form>
                    @endif

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
@endsection
