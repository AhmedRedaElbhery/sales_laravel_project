@extends('layouts.admin');

@section('title')
    ضبط المخان
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
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title card_title_center">بيانات الاصناف </h3>
                    <a class="btn btn-success" href="{{ route('itemcard.create') }}">اضافه جديد</a>
                </div>

                <div class="card-body">

                    @if (isset($data) && count($data) > 0)
                        <div id="ajax_responce_searchDiv">

                            <table class="table table-bordered table-hover text-center">
                                <thead class="custom_head">
                                    <tr>
                                        <th>التسلسل</th>
                                        <th>الاسم</th>
                                        <th>النوع</th>
                                        <th>الفئه </th>
                                        <th>الصنف الاب </th>
                                        <th>الوحده الاب </th>
                                        <th>الوحده التحزئه </th>
                                        <th>حاله التفعيل</th>
                                        <th> </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>

                                            <td>{{ $item->name }}</td>
                                            <td>
                                                @if ($item->item_type == 1)
                                                    <span class="badge badge-success">مخزني</span>
                                                @elseif($item->item_type == 2)
                                                    <span class="badge badge-success">استهلاكى بصلاحيه</span>
                                                @elseif($item->item_type == 3)
                                                    <span class="badge badge-success">عهده</span>
                                                @else
                                                    <span class="badge badge-danger">غير محدد </span>
                                                @endif
                                            </td>

                                            <td>{{ $item->category_name }}</td>
                                            <td>{{ $item->parent_name }}</td>
                                            <td>{{ $item->unit_name }}</td>
                                            <td>{{ $item->retail_unit_name }}</td>

                                            <td>
                                                @if ($item->active == 1)
                                                    <span class="badge badge-success">مفعل</span>
                                                @else
                                                    <span class="badge badge-danger">معطل</span>
                                                @endif
                                            </td>

                                            <td>
                                                <a href="{{ route('itemcard.edit', $item->id) }}"
                                                    class="btn btn-primary">تعديل</a>

                                                <form action="{{ route('itemcard.destroy', $item->id) }}" method="POST"
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
