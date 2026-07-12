@extends('layouts.admin');

@section('title')
    المشتريات
@endsection

@section('contentheader')
    حركات مخزنيه
@endsection

@section('contentheaderlink')
    <a href="{{ route('supplier_orders.index') }}"> فواتير المشتريات </a>
@endsection


@section('contentheaderactive')
    عرض
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title card_title_center">فواتير المشتريات من الموردين </h3>
                    <a class="btn btn-success" href="{{ route('supplier_orders.create') }}">اضافه فاتوره جديده</a>
                </div>

                <div class="card-body">

                    @if (isset($data) && count($data) > 0)
                        <div id="ajax_responce_searchDiv">

                            <table class="table table-bordered table-hover text-center">
                                <thead class="custom_head">
                                    <tr>
                                        <th>كود الفاتوره</th>
                                        <th>اسم المورد</th>
                                        <th>نوع الفاتوره</th>
                                        <th>المخزن</th>
                                        <th>تاريخ الفاتوره</th>
                                        <th>حاله الاعتماد </th>
                                        <th> </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $item->auto_serial }}</td>

                                            <td>{{ $item->supplier_name }}</td>
                                            <td>
                                                @if ($item->doc_type == 1)
                                                    فاتوره مشتريات
                                                @elseif ($item->doc_type == 2)
                                                    فاتوره مرتحعات
                                                @else
                                                    فاتوره مشتريات
                                                @endif
                                            </td>

                                            <td>
                                                {{ $item->store_name }}
                                            </td>

                                            <td>
                                                {{ $item->order_date }}

                                            </td>

                                            <td>
                                                @if ($item->is_approved == 0)
                                                    <span class="badge badge-danger p-2">غير معتمده</span>
                                                @else
                                                    <span class="badge badge-success p-2">معتمده</span>
                                                @endif
                                            </td>

                                            <td>


                                                <a href="{{ route('supplier_orders.show', $item->id) }}"
                                                    class="btn btn-info">التفاصيل</a>

                                                <form action="{{ route('supplier_orders.destroy', $item->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
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
