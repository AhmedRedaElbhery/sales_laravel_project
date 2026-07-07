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
    إضافة
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title card_title_center">استلام خزنه لشفت جديد</h3>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger text-center">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('admin_shifts.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>الخزن المتاحه للاستخدام </label>
                            <select name="treasuries_id" class="form-control">
                                <option value="" selected disabled>اختر نوع الوحده</option>
                                @foreach ($treasuries as $item)
                                    @if ($item->status == true)
                                        <option value="{{ $item->treasuries_id }}">
                                            {{ $item->name }}</option>
                                    @endif
                                @endforeach

                            </select>
                            @error('treasuries_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary m-2">
                            حفظ
                        </button>

                        <a href="{{ route('admin_shifts.index') }}" class="btn btn-secondary">
                            رجوع
                        </a>

                    </form>

                </div>

            </div>
        </div>
    </div>
@endsection
