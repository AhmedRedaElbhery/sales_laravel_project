@extends('layouts.admin');

@section('title')
الوحدات
@endsection

@section('contentheader')
    الوحدات
@endsection

@section('contentheaderlink')
    <a href="{{ route('unit.index') }}"> الوحدات </a>
@endsection


@section('contentheaderactive')
    عرض
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title card_title_center">بيانات الوحدات </h3>
                    <a class="btn btn-success" href="{{ route('unit.create') }}">اضافه وحده جديده</a>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" id="search_by_name" placeholder="بحث بالاسم" class="form-control mb-3">
                        </div>

                        <div class="col-md-4">
                            <form action="{{ route('unit.filter') }}" method="POST">
                                @csrf
                                <select name="type" class="form-control" onchange="this.form.submit()">
                                    @if (!isset($type))
                                        <option value="all">عرض الكل</option>
                                        <option value="1">وحدات رئيسيه</option>
                                        <option value="0">وحدات فرعيه</option>
                                    @else
                                        @if ($type == 0)
                                            <option value="all" >عرض الكل</option>
                                            <option value="1">وحدات رئيسيه</option>
                                            <option value="0" selected>وحدات فرعيه</option>
                                        @elseif($type == 1)
                                            <option value="all">عرض الكل</option>
                                            <option value="1" selected>وحدات رئيسيه</option>
                                            <option value="0">وحدات فرعيه</option>
                                        @else
                                            <option value="all" selected>عرض الكل</option>
                                            <option value="1">وحدات رئيسيه</option>
                                            <option value="0" >وحدات فرعيه</option>
                                        @endif
                                    @endif
                                </select>
                            </form>
                        </div>
                    </div>



                    @if (isset($data) && count($data) > 0)
                        <div id="ajax_responce_searchDiv">

                            <table class="table table-bordered table-hover text-center">
                                <thead class="custom_head">
                                    <tr>
                                        <th>التسلسل</th>
                                        <th>اسم الوحده</th>
                                        <th>رئيسيه؟</th>
                                        <th>حاله التفعيل</th>
                                        <th>تاريخ الاضافه</th>
                                        <th>تاريخ التحديث</th>
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
                                                    وحده رئيسية
                                                @else
                                                    وحده فرعية
                                                @endif
                                            </td>

                                            <td>
                                                @if ($item->active == 1)
                                                    <span class="badge badge-success">مفعل</span>
                                                @else
                                                    <span class="badge badge-danger">معطل</span>
                                                @endif
                                            </td>

                                            <td>
                                                @if ($item['created_at'] != null)
                                                    {{ $item['created_at']->format('Y-m-d h:i') . ' ' . ($item['created_at']->format('A') == 'AM' ? 'صباحاً' : 'مساءً') }}
                                                    بواسطه
                                                    {{ $item['added_by_admin'] }}
                                                @else
                                                    لا يوجد
                                                @endif

                                            </td>

                                            <td>
                                                @if ($item['updated_by'] > 0 && $item['updated_at'] != null)
                                                    {{ $item['updated_at']->format('Y-m-d h:i') . ' ' . ($item['updated_at']->format('A') == 'AM' ? 'صباحاً' : 'مساءً') }}
                                                    بواسطه
                                                    {{ $item['updated_by_admin'] }}
                                                @else
                                                    لا يوجد
                                                @endif
                                            </td>


                                            <td>
                                                <a href="{{ route('unit.edit', $item->id) }}"
                                                    class="btn btn-primary">تعديل</a>

                                                <form action="{{ route('unit.destroy', $item->id) }}" method="POST"
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
