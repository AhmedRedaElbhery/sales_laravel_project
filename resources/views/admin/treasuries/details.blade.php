@extends('layouts.admin');

@section('title')
    الضبط العام
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
                    <h3 class="card-title card_title_center">بيانات الخزنه</h3>
                </div>

                <div class="card-body">
                    @if (isset($data))
                        <table id="example2" class="table table-bordered table-hover">
                            <tr>
                                <td class="width30">اسم الخزنه</td>
                                <td>{{ $data['name'] }}</td>
                            </tr>

                            <tr>
                                <td class="width30">اخر ايصال صرف</td>
                                <td>{{ $data['last_isal_exchange'] }}</td>
                            </tr>

                            <tr>
                                <td class="width30">اخر ايصال تحصيل</td>
                                <td>{{ $data['last_isal_collect'] }}</td>
                            </tr>

                            <tr>
                                <td>حاله الخزنه</td>
                                <td>
                                    @if ($data['active'] == 1)
                                        مفعل
                                    @else
                                        غير مفعل
                                    @endif
                                </td>
                            </tr>


                            <tr>
                                <td> هل رئيسيه؟</td>
                                <td>
                                    @if ($data['is_master'] == 1)
                                        رئيسيه
                                    @else
                                        غير رئيسيه
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td>تاريخ الاضافه </td>
                                <td>
                                    @if ($data['added_by'] > 0 && $data['added_by'] != null)
                                        @php
                                            $dt = new DateTime($data['created_at']);
                                            $date = $dt->format('Y-m-d');
                                            $time = $dt->format('h-i');
                                            $newdatetime = date('A', strtotime($time));
                                            $newdatetimetype = $newdatetime == 'AM' ? 'صباحا' : 'مساء';
                                        @endphp
                                        {{ $date }}
                                        {{ $time }}
                                        {{ $newdatetimetype }}
                                        بواسطه
                                        {{ $data['added_by_admin'] }}
                                    @else
                                        لا يوجد
                                    @endif
                                </td>

                            </tr>

                            <tr>
                                <td>تاريخ اخر تحديث </td>
                                <td>
                                    @if ($data['updated_by'] > 0 && $data['updated_by'] != null)
                                        @php
                                            $dt = new DateTime($data['updated_at']);
                                            $date = $dt->format('Y-m-d');
                                            $time = $dt->format('h-i');
                                            $newdatetime = date('A', strtotime($time));
                                            $newdatetimetype = $newdatetime == 'PM' ? 'صباحا' : 'مساء';
                                        @endphp
                                        {{ $date }}
                                        {{ $time }}
                                        {{ $newdatetimetype }}
                                        بواسطه
                                        {{ $data['updated_by_admin'] }}
                                    @else
                                        لا يوجد
                                    @endif
                                    <a href="{{ route('admin.treasuries.edit', $data->id) }}"
                                        class="btn btn-primary">تعديل</a>
                                </td>
                            </tr>

                        </table>
                        <br>
                    @else
                        <div class="alert alert-warning">
                            لا توجد بيانات
                        </div>
                    @endif

                    @if (isset($treasuries_delivary) && count($treasuries_delivary) > 0)
                    <div class="card-header">
                        <h3 class="card-title card_title_center">الخزن الفرعيه للخزنه ({{ $data['name'] }})</h3>
                    </div>
                    <a href="{{ route('admin.treasuries.add_treasuries_branch',$data->id) }}" class="btn btn-primary m-3" > اضافه جديد</a>
                            <table class="table table-bordered table-hover text-center">
                                <thead class="custom_head">
                                    <tr>
                                        <th>التسلسل</th>
                                        <th>اسم الخزن</th>
                                        <th>تاريخ الاضافه </th>
                                        <th> </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($treasuries_delivary as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>

                                            <td>{{ $item->name }}</td>

                                            <td>
                                                @if ($item['created_at'] != null)
                                                    @php
                                                        $dt = new DateTime($data['created_at']);
                                                        $date = $dt->format('Y-m-d');
                                                        $time = $dt->format('h-i');
                                                        $newdatetime = date('A', strtotime($time));
                                                        $newdatetimetype = $newdatetime == 'PM' ? 'صباحا' : 'مساء';
                                                    @endphp
                                                    {{ $date }}
                                                    {{ $time }}
                                                    {{ $newdatetimetype }}
                                                    بواسطه
                                                    {{ $item['added_by_admin'] }}
                                                @else
                                                    لا يوجد
                                                @endif

                                            </td>
                                            <td>
                                                <form action="{{ route('admin.treasuries.delete', $item->id) }}"
                                                    method="POST"
                                                    style="display:inline;">
                                                  @csrf
                                                  @method('DELETE')

                                                  <button type="submit" class="btn btn-danger">
                                                      حذف
                                                  </button>
                                              </form>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
