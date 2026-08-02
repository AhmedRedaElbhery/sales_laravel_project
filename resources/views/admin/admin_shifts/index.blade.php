@extends('layouts.admin')

@section('title')
    {{ __('adminShifts.title') }}
@endsection

@section('contentheader')
    {{ __('adminShifts.content_header') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin_shifts.index') }}">
        {{ __('adminShifts.content_header_link') }}
    </a>
@endsection

@section('contentheaderactive')
    {{ __('adminShifts.content_header_active') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title card_title_center">
                        {{ __('adminShifts.treasury_shifts_data') }}
                    </h3>

                    <a class="btn btn-success" href="{{ route('admin_shifts.create') }}">
                        {{ __('adminShifts.add_new_shift') }}
                    </a>
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
                                    ...
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
                                        <th>{{ __('adminShifts.serial') }}</th>
                                        <th>{{ __('adminShifts.treasury_name') }}</th>
                                        <th>{{ __('adminShifts.user_name') }}</th>
                                        <th>{{ __('adminShifts.usage_status') }}</th>
                                        <th>{{ __('adminShifts.start_time') }}</th>
                                        <th>{{ __('adminShifts.end_time') }}</th>
                                        <th>{{ __('adminShifts.review_status') }}</th>
                                        {{-- <th></th> --}}
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
                                                    <span class="badge badge-danger p-2">
                                                        {{ __('adminShifts.in_use') }}
                                                    </span>
                                                @elseif($item->is_finished == 1 && $item->end_shift != null)
                                                    <span class="badge badge-success p-2">
                                                        {{ __('adminShifts.finished') }}
                                                    </span>
                                                @else
                                                    <span class="badge badge-danger p-2">
                                                        {{ __('adminShifts.in_use') }}
                                                    </span>
                                                @endif
                                            </td>

                                            <td>
                                                @if ($item->start_shift != null)
                                                    {{ $item->start_shift }}
                                                @else
                                                    {{ __('adminShifts.no_data') }}
                                                @endif
                                            </td>

                                            <td>
                                                @if ($item->end_shift != null)
                                                    {{ $item->end_shift }}
                                                @else
                                                    {{ __('adminShifts.still_working') }}
                                                @endif
                                            </td>

                                            <td>
                                                @if ($item->is_delivered == 1)
                                                    {{ __('adminShifts.reviewed') }}
                                                @else
                                                    {{ __('adminShifts.not_reviewed') }}
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
                            {{ __('adminShifts.no_records') }}
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