@extends('layouts.admin')

@section('title')
    تعديل حساب
@endsection

@section('contentheader')
تعديل حساب
@endsection

@section('contentheaderlink')
    <a href="{{ route('accounts.index') }}"> الحسابات الماليه </a>
@endsection

@section('contentheaderactive')
    تعديل
@endsection

@section('content')
    <div class="card">

        <div class="card-header">
            <h3 class="card-title card_title_center">تعديل حساب</h3>
        </div>

        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger text-center">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('accounts.update', $data->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div>

                    <div class="row mb-2">

                        <div class="form-group col-sm-6">
                            <label>اسم الحساب </label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $data->name) }}">

                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label>نوع الحساب </label>

                            <select name="account_type" class="form-control">
                                <option value="" selected disabled>{{ $account_type->name }}</option>
                            </select>

                            @error('account_type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="row mb-2">

                        <div class="form-group col-sm-6">
                            <label>الحساب الاساسى له</label>

                            <select name="parent_account_number" class="form-control">
                                <option value="" disabled>اختر الحساب الاب له</option>

                                <option value="0"
                                    @selected(old('parent_account_number', $data->parent_account_number) == 0)>
                                    هذا الحساب اساسى
                                </option>

                                @foreach ($accounts as $item)
                                @if ($item->id != $data->id)
                                <option value="{{ $item->id }}"
                                    @selected(old('parent_account_number', $data->parent_account_number) == $item->id)>
                                    {{ $item->name }}
                                </option>
                                @endif

                                @endforeach
                            </select>

                            @error('parent_account_number')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label>حاله التفعيل</label>

                            <select name="is_archived" class="form-control">
                                <option value="" disabled>اختر الحاله</option>

                                <option value="0"
                                    @selected(old('is_archived', $data->is_archived) == 0)>
                                    مفعل
                                </option>

                                <option value="1"
                                    @selected(old('is_archived', $data->is_archived) == 1)>
                                    مؤرشف وغير مفعل
                                </option>
                            </select>

                            @error('is_archived')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="form-group col-sm-5">
                        <label>الملاحظات</label> <br>

                        <textarea name="notes" style="height: 100px; width: 420px">{{ old('notes', $data->notes) }}</textarea>

                        @error('notes')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <button type="submit" class="btn btn-primary m-5 p-2 col-sm-5">
                    تحديث
                </button>

                <a href="{{ route('accounts.index') }}" class="btn btn-secondary m-4 p-2 col-sm-5">
                    رجوع
                </a>

            </form>

        </div>

    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            $('#start_balance_status').change(function() {

                if ($(this).val() == 3) {
                    $('#start_balance').val(0);
                }

            });

        });
    </script>
@endsection