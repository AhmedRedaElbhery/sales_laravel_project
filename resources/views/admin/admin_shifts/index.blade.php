@extends('layouts.admin');

@section('title')
    حركه شفتات الخزن
@endsection

@section('contentheader')
    حركه شفتات الخزن
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin_shifts.index') }}"> شفتات الخزن </a>
@endsection


@section('contentheaderactive')
    عرض
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title card_title_center">بيانات شفتات الخزن </h3>
                    <a class="btn btn-success" href="{{ route('admin_shifts.create') }}">اضافه شفت جديده</a>
                </div>

                <div class="card-body">
                    {{-- <div class="row">
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
                    </div> --}}



                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if (isset($data) && count($data) > 0)
                        <div id="ajax_responce_searchDiv">

                            <table class="table table-bordered table-hover text-center">
                                <thead class="custom_head">
                                    <tr>
                                        <th>التسلسل</th>
                                        <th>اسم الخزنه</th>
                                        <th>اسم المستخدم</th>
                                        <th>حاله الاستخدام</th>
                                        <th>وقت البدايه</th>
                                        <th>وقت النهايه</th>
                                        <th>حاله المراجعه</th>
                                        {{-- <th> </th> --}}
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>

                                            <td>{{ $item->name }}</td>
                                            <td>
                                                {{ $item->added_by_admin }}
                                            </td>

                                            <td>
                                                @if ($item->is_finished == 0 && $item->end_shift == null)
                                                    <span class="badge badge-danger p-2">يتم الاستخدام</span>
                                                @elseif($item->is_finished == 1 && $item->end_shift != null)
                                                    <span class="badge badge-success p-2">انتهى</span>
                                                @else
                                                    <span class="badge badge-danger p-2">يتم الاستخدام</span>
                                                @endif
                                            </td>

                                            <td>
                                                @if ($item->start_shift != null)
                                                    {{ $item->start_shift }}
                                                @else
                                                    لا يوجد
                                                @endif

                                            </td>

                                            <td>
                                                @if ($item->end_shift != null)
                                                    {{ $item->end_shift }}
                                                @else
                                                    مازال يعمل
                                                @endif
                                            </td>

                                            <td>
                                                @if ($item->is_delivered == 1)
                                                    تمت المراجعه
                                                @else
                                                    لم تتمت المراجعه بعد
                                                @endif
                                            </td>


                                            {{-- <td>
                                                <a href="{{ route('admin_shifts.edit', $item->id) }}"
                                                    class="btn btn-primary">تعديل</a>

                                                <form action="{{ route('admin_shifts.destroy', $item->id) }}" method="POST"
                                                    class="d-inline" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">حذف</button>
                                                </form>
                                            </td> --}}
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
