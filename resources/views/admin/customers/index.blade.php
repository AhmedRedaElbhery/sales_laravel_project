@extends('layouts.admin');

@section('title')
حسابات العملاء
@endsection

@section('contentheader')
ضبط المخازن
@endsection

@section('contentheaderlink')
    <a href="{{ route('customers.index') }}"> حسابات العملاء </a>
@endsection


@section('contentheaderactive')
    عرض
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title card_title_center">حسابات العملاء </h3>
                    <a class="btn btn-success" href="{{ route('customers.create') }}">اضافه جديد</a>
                </div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" id="search_by_name" placeholder="بحث بالاسم" class="form-control mb-3">
                        </div>


                    </div>

                    @if (isset($data) && count($data) > 0)
                        <div id="ajax_responce_searchDiv">

                            <table class="table table-bordered table-hover text-center">
                                <thead class="custom_head">
                                    <tr>
                                        <th>الاسم</th>
                                        <th>كود او رقم العميل</th>
                                        <th>رقم الحساب </th>
                                        <th>الرصيد الحالى </th>
                                        <th>حاله التفعيل</th>
                                        <th> </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->customer_code }}</td>

                                            <td>{{ $item->account_number }}</td>

                                            <td>{{ $item->current_balance }}</td>

                                            <td>
                                                @if ($item->is_archived == 0)
                                                    <span class="badge badge-success">مفعل</span>
                                                @else
                                                    <span class="badge badge-danger">مؤرشف وغير مفعل</span>
                                                @endif
                                            </td>

                                            <td>
                                                <a href="{{ route('customers.edit', $item->id) }}"
                                                    class="btn btn-primary">تعديل</a>

                                                <a href="{{ route('customers.show', $item->id) }}"
                                                    class="btn btn-info">عرض</a>

                                                <form action="{{ route('customers.destroy', $item->id) }}" method="POST"
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
    <script src="{{ asset('assets/admin/js/ajax_search.js') }}"></script>
@endsection
