@extends('layouts.admin');

@section('title')
    الحسابات
@endsection

@section('contentheader')
    الحسابات الماليه
@endsection

@section('contentheaderlink')
    <a href="{{ route('accounts.index') }}"> الحسابات الماليه </a>
@endsection


@section('contentheaderactive')
    عرض
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title card_title_center">الحسابات الماليه </h3>
                    <a class="btn btn-success" href="{{ route('itemcard.create') }}">اضافه جديد</a>
                </div>

                <div class="card-body">

                    <div class="col-md-4">
                        <input type="text" id="search_by_name" placeholder="بحث بالاسم" class="form-control mb-3">
                    </div>

                    @if (isset($data) && count($data) > 0)
                        <div id="ajax_responce_searchDiv">

                            <table class="table table-bordered table-hover text-center">
                                <thead class="custom_head">
                                    <tr>
                                        <th>الاسم</th>
                                        <th>رقم الحساب </th>
                                        <th>نوع الحساب</th>
                                        <th>هل اب </th>
                                        <th>الحساب الاب له</th>
                                        <th>الرصيد </th>
                                        <th>حاله التفعيل</th>
                                        <th> </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->account_number }}</td>
                                            <td>
                                                {{ $item->type }}
                                            </td>

                                            <td>
                                                @if ( $item->is_parent == 1)
                                                    <span class="badge badge-success">نعم</span>
                                                @else
                                                    <span class="badge badge-danger">لا</span>
                                                @endif
                                            </td>

                                            <td>
                                                {{ $item->parent_account_name }}

                                            </td>

                                            <td>{{ $item->current_balance }}</td>

                                            <td>
                                                @if ($item->is_archived == 0)
                                                    <span class="badge badge-success">مفعل</span>
                                                @else
                                                    <span class="badge badge-danger">معطل</span>
                                                @endif
                                            </td>

                                            <td>
                                                <a href="{{ route('accounts.edit', $item->id) }}"
                                                    class="btn btn-primary">تعديل</a>

                                                <a href="{{ route('accounts.show', $item->id) }}"
                                                    class="btn btn-info">عرض</a>

                                                <form action="{{ route('accounts.destroy', $item->id) }}" method="POST"
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
