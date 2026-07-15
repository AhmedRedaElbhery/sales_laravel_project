@extends('layouts.admin');

@section('title')
    شاشه الصرف
@endsection

@section('contentheader')
    شاشه الصرف
@endsection

@section('contentheaderlink')
    <a href="{{ route('exchange_transaction.index') }}"> شاشه الصرف </a>
@endsection


@section('contentheaderactive')
    عرض
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title card_title_center">بيانات شاشه الصرف</h3>
                </div>



                <div class="card-body">

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif


                    @if ($exist != null)
                        <form action="{{ route('exchange_transaction.store') }}" method="POST"
                            style="border: 1px solid gray; padding: 10px">
                            @csrf

                            <div>
                                <div class="row mb-2">

                                    <div class="form-group col-sm-4">
                                        <label>الخزنه المتاحه </label>
                                        <select name="treasuries_id" id="treasuries_id" class="form-control">
                                            <option value="{{ $exist->treasuries_id }}"
                                                {{ old('treasuries_id', $exist->treasuries_id) == $exist->treasuries_id ? 'selected' : '' }}>
                                                {{ $exist->treasuries_name }}
                                            </option>
                                        </select>
                                        @error('treasuries_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                     <div class="form-group col-sm-4">
                                        <label>اختر الحساب </label>
                                        <select name="account_number" id="account_number" class="form-control">
                                            <option value="" disabled {{ old('account_number') ? '' : 'selected' }}>
                                                اختر الحساب
                                            </option>

                                            @foreach ($accounts as $account)
                                                <option value="{{ $account->account_number }}"
                                                    {{ old('account_number') == $account->account_number ? 'selected' : '' }}>
                                                    {{ $account->name }} ({{ $account->account_type_name }})
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('account_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-4">
                                        <label>نوع الحركه </label>
                                        <select name="move_type" id="move_type" class="form-control">
                                            <option value="" selected disabled>اختر نوع الحركه</option>
                                            @foreach ($move_types as $move_type)
                                                <option value="{{ $move_type->id }}"
                                                    {{ old('move_type') == $move_type->id ? 'selected' : '' }}>
                                                    {{ $move_type->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('move_type')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>





                                </div>

                                <div class="row">

                                    <div class="form-group col-4">
                                        <label>الرصيد المتاح بالخزنه</label>
                                        <input readonly class="form-control" type="number" name="treasuries_balance"
                                            value="{{ old('treasuries_balance', $treasuries_balance / 100) }}">

                                        @error('treasuries_balance')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-4">
                                        <label>تاريخ الحركه</label>
                                        <input class="form-control" type="date" name="date"
                                            value="{{ old('date') }}">

                                        @error('date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>


                                    <div class="form-group col-4">
                                        <label>الرصيد المصروف</label>
                                        <input
                                            @if ($treasuries_balance / 100 <= 0) disabled placeholder="الرصيد لا يسمح" @endif
                                            class="form-control" type="number" name="money" id="money"
                                            value="{{ old('money') }}">

                                        @error('money')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="form-group col-sm-6">
                                        <label>البيان</label>
                                        <textarea name="byan" class="form-control" style="height: 100px;">{{ old('byan') }}</textarea>

                                        @error('byan')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>

                            </div>

                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary m-2" style="padding: 8px 15px;">
                                    صرف
                                </button>
                            </div>

                        </form>
                    @else
                        <div class="alert alert-danger">
                            لا يوجد شفت مفتوح لك
                        </div>
                    @endif


                    @if (isset($data) && count($data) > 0)
                        <div id="ajax_responce_searchDiv">

                            <table class="table table-bordered table-hover text-center">
                                <thead class="custom_head">
                                    <tr>
                                        <th>كود ايصال الصرف</th>
                                        <th>الخزنه</th>
                                        <th>المبلغ المصروف</th>
                                        <th>نوع الحركه</th>
                                        <th>بيان الحركه</th>
                                        <th>المستخدم</th>

                                        <th> </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $item->isal_number }}</td>

                                            <td>{{ $item->treasuries_name }}</td>

                                            <td>
                                                {{ $item->money_for_account / 100 }}
                                            </td>

                                            <td>
                                                {{ $item->move_type_name }}
                                            </td>

                                            <td>
                                                {{ $item->byan }}
                                            </td>

                                            <td>{{ $item->created_at }} <br> بواسطه {{ $item->admin_name }}</td>

                                            <td>
                                                <a href="#" class="btn btn-primary">طباعه</a>
                                                <a href="#" class="btn btn-info">المزيد</a>
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
@endsection

@section('script')
    <script src="{{ asset('assets/admin/js/transaction.js') }}"></script>
@endsection
