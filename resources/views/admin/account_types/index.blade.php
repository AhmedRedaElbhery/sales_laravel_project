@extends('layouts.admin');

@section('title')
 الحسابات
@endsection

@section('contentheader')
انواع الحسابات
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin.accounttypes.index') }}"> انواع الحسابات </a>
@endsection


@section('contentheaderactive')
    عرض
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title card_title_center">انواع الحسابات </h3>
                </div>

                <div class="card-body">

                    @if (isset($data) && count($data) > 0)
                        <div>

                            <table class="table table-bordered table-hover text-center">
                                <thead class="custom_head">
                                    <tr>
                                        <th>التسلسل</th>
                                        <th>اسم الحساب</th>
                                        <th>حاله التفعيل</th>
                                        <th>يمكن اضافته من الشاشه الداخليه؟</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>

                                            <td>{{ $item->name }}</td>

                                            <td>
                                                @if ($item->active == 1)
                                                    <span class="badge badge-success">مفعل</span>
                                                @else
                                                    <span class="badge badge-danger">معطل</span>
                                                @endif
                                            </td>

                                            <td>
                                                @if ($item->relatedinternalaccounts == 1)
                                                    <span class="badge badge-success">نعم يمكن اضافته</span>
                                                @elseif(($item->relatedinternalaccounts == 0))
                                                    <span class="badge badge-danger">لا يمكن هذا رئيسى</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <br>
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
