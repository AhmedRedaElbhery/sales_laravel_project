@extends('layouts.admin');

@section('title')
الصلاحيات
@endsection

@section('contentheader')
    المستخدمين
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin_accounts.index') }}"> المستخدمين </a>
@endsection


@section('contentheaderactive')
    عرض
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title card_title_center">بيانات المستخدمين </h3>
                    <a class="btn btn-success" href="{{ route('admin_accounts.create') }}">اضافه جديد</a>
                </div>

                <div class="card-body">

                    @if (isset($data) && count($data) > 0)
                        <div id="ajax_responce_searchDiv">

                            <table class="table table-bordered table-hover text-center">
                                <thead class="custom_head">
                                    <tr>
                                        <th>التسلسل</th>
                                        <th>اسم المستخدم</th>
                                        <th>الايميل</th>
                                        <th>تاريخ الاضافه</th>
                                        <th> </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>

                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>

                                            <td>
                                                @if ($item['created_at'] != null)
                                                {{ $item['created_at']->format('Y-m-d h:i') . ' ' . ($item['created_at']->format('A') == 'AM' ? 'صباحاً' : 'مساءً') }}
                                                    بواسطه<br>
                                                    {{ $item['added_by_admin'] }}
                                                @else
                                                    لا يوجد
                                                @endif

                                            </td>

                                            <td>
                                                <a href="{{ route('admin_accounts.edit', $item->id) }}"
                                                    class="btn btn-primary">تعديل</a>

                                                    <a href="{{ route('admin_accounts.show', $item->id) }}"
                                                        class="btn btn-info">المزيد</a>

                                                <form action="{{ route('admin_accounts.destroy', $item->id) }}"
                                                    method="POST"
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
