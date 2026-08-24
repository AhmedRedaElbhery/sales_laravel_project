@extends('layouts.admin');

@section('title')
    {{ __('treasuries.title') }}
@endsection

@section('contentheader')
{{ __('treasuries.title') }}
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin.treasuries.index') }}">  {{ __('treasuries.title') }} </a>
@endsection


@section('contentheaderactive')
{{ __('treasuries.show') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                @if (session('success'))
                    <div class="alert alert-success text-center">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger text-center">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="card-header">
                    <h3 class="card-title card_title_center"> {{ __('treasuries.treasuries_data') }}</h3>
                </div>

                <div class="card-body">
                    @if (isset($data))
                        <table id="example2" class="table table-bordered table-hover">
                            <tr>
                                <td class="width30">{{ __('treasuries.treasury_name') }}</td>
                                <td>{{ $data['name'] }}</td>
                            </tr>

                            <tr>
                                <td class="width30">{{ __('treasuries.last_exchange_receipt') }}</td>
                                <td>{{ $data['last_isal_exchange'] }}</td>
                            </tr>

                            <tr>
                                <td class="width30">{{ __('treasuries.last_collect_receipt') }}</td>
                                <td>{{ $data['last_isal_collect'] }}</td>
                            </tr>

                            <tr>
                                <td>{{ __('treasuries.status') }}</td>
                                <td>
                                    @if ($data['active'] == 1)
                                    {{ __('treasuries.active') }}
                                    @else
                                    {{ __('treasuries.inactive') }}
                                    @endif
                                </td>
                            </tr>


                            <tr>
                                <td> {{ __('treasuries.is_master') }}</td>
                                <td>
                                    @if ($data['is_master'] == 1)
                                    {{ __('treasuries.master') }}
                                    @else
                                    {{ __('treasuries.branch') }}
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td> {{ __('treasuries.date_added') }}  </td>
                                <td>
                                    @if ($data['added_by'] > 0 && $data['added_by'] != null)
                                        @php
                                            $dt = new DateTime($data['created_at']);
                                            $date = $dt->format('Y-m-d');
                                            $time = $dt->format('h-i');
                                            $newdatetime = date('A', strtotime($time));
                                            $newdatetimetype = $newdatetime == 'AM' ? __('treasuries.am') : __('treasuries.pm'); @endphp
                                        {{ $date }}
                                        {{ $time }}
                                        {{ $newdatetimetype }}
                                        {{ __('treasuries.by') }}
                                        {{ $data['added_by_admin'] }}
                                    @else
                                    {{ __('treasuries.none') }}
                                    @endif
                                </td>

                            </tr>

                            <tr>
                                <td> {{ __('treasuries.last_update') }}   </td>
                                <td>
                                    @if ($data['updated_by'] > 0 && $data['updated_by'] != null)
                                        @php
                                            $dt = new DateTime($data['updated_at']);
                                            $date = $dt->format('Y-m-d');
                                            $time = $dt->format('h-i');
                                            $newdatetime = date('A', strtotime($time));
                                            $newdatetimetype = $newdatetime == 'AM' ? __('treasuries.am') : __('treasuries.pm');
                                        @endphp
                                        {{ $date }}
                                        {{ $time }}
                                        {{ $newdatetimetype }}
                                        {{ __('treasuries.by') }}
                                        {{ $data['updated_by_admin'] }}
                                    @else
                                    {{ __('treasuries.none') }}
                                    @endif
                                    <a href="{{ route('admin.treasuries.edit', $data->id) }}"
                                        class="btn btn-primary m-2"> {{ __('treasuries.edit') }} </a>

                                        <a href="{{ route('admin.treasuries.index')}}"
                                            class="btn btn-danger m-2"> {{ __('treasuries.cancel') }} </a>
                                </td>
                            </tr>

                        </table>
                        <br>
                    @else
                        <div class="alert alert-warning">
                            {{ __('treasuries.no_data') }}
                        </div>
                    @endif

                    @if (isset($treasuries_delivary) && count($treasuries_delivary) > 0)
                    <div class="card-header">
                        <h3 class="card-title card_title_center">{{ __('treasuries.branch_treasuries') }}  ({{ $data['name'] }})</h3>
                    </div>
                    <a href="{{ route('admin.treasuries.add_treasuries_branch',$data->id) }}" class="btn btn-primary m-3" > {{ __('treasuries.add_new') }}</a>
                            <table class="table table-bordered table-hover text-center">
                                <thead class="custom_head">
                                    <tr>
                                        <th> {{ __('treasuries.serial') }} </th>
                                        <th> {{ __('treasuries.treasury_name') }} </th>
                                        <th> {{ __('treasuries.date_added') }}  </th>
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
                                                        $newdatetimetype = $newdatetime == 'AM' ? __('treasuries.am') : __('treasuries.pm');  @endphp
                                                    {{ $date }}
                                                    {{ $time }}
                                                    {{ $newdatetimetype }}
                                                    {{ __('treasuries.by') }}
                                                    {{ $item['added_by_admin'] }}
                                                @else
                                                {{ __('treasuries.none') }}
                                                @endif

                                            </td>
                                            <td>
                                                <form action="{{ route('admin.treasuries.delete', $item->id) }}"
                                                    method="POST"
                                                    style="display:inline;"
                                                    onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                                  @csrf
                                                  @method('DELETE')

                                                  <button type="submit" class="btn btn-danger">
                                                    {{ __('treasuries.delete') }}
                                                  </button>
                                              </form>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    @else
                        <div class="alert alert-warning">
                            {{ __('treasuries.no_data') }}
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
