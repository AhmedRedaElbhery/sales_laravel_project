@extends('layouts.admin');

@section('title')
الخزن
@endsection

@section('contentheader')
    الخزن
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin.treasuries.index') }}"> الخزن </a>
@endsection


@section('contentheaderactive')
    عرض
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title card_title_center">بيانات الخزن</h3>
                </div>

                <div class="card-body">
                    <a class="btn btn-success m-2" href="{{ route('admin.treasuries.create') }}">اضافه جديد</a>


                    <div class="col-md-4">
                        <input type="text" id="search_by_name" placeholder="بحث بالاسم" class=" form-control mb-3">
                    </div>
                    @if (isset($data) && count($data) > 0)
                        <div id="ajax_responce_searchDiv">

                            <table class="table table-bordered table-hover text-center">
                                <thead class="custom_head">
                                    <tr>
                                        <th>التسلسل</th>
                                        <th>اسم الخزن</th>
                                        <th>هل رئيسيه</th>
                                        <th>حاله التفعيل</th>
                                        <th>كود الشركه التابع له</th>
                                        <th>آخر ايصال صرف</th>
                                        <th>آخر ايصال تحصيل</th>
                                        <th> </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>

                                            <td>{{ $item->name }}</td>

                                            <td>
                                                @if ($item->is_master == 1)
                                                    رئيسية
                                                @else
                                                    فرعية
                                                @endif
                                            </td>

                                            <td>
                                                @if ($item->active == 1)
                                                    <span class="badge badge-success">مفعل</span>
                                                @else
                                                    <span class="badge badge-danger">معطل</span>
                                                @endif
                                            </td>

                                            <td>{{ $item->com_code }}</td>
                                            <td>{{ $item->last_isal_exchange }}</td>
                                            <td>{{ $item->last_isal_collect }}</td>

                                            <td>
                                                <a href="{{ route('admin.treasuries.edit', $item->id) }}"
                                                    class="btn btn-primary">تعديل</a>
                                                <a href="{{ route('admin.treasuries.details', $item->id) }}" class="btn btn-info">المزيد</a>

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
