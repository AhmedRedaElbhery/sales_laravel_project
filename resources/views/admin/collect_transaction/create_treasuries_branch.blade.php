@extends('layouts.admin')

@section('title')
    إضافة خزنة فرعيه
@endsection

@section('contentheader')
    الخزن
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin.treasuries.index') }}"> الخزن </a>
@endsection

@section('contentheaderactive')
    إضافة
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">إضافة خزنة فرعيه جديدة</h3>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger text-center">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.treasuries.store_treasuries_branch',$id) }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>اسم الخزنة</label>
                            <select name="treasury_name" class="form-control">
                                <option value="">اختر الخزنه </option>
                                @foreach ($data as $treasury)
                                    <option value="{{ $treasury->id }}">{{ $treasury->name }}</option>
                                @endforeach
                            </select>
                            @error('treasury_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <button type="submit" class="btn btn-primary">
                            حفظ
                        </button>

                        <a href="{{ route('admin.treasuries.details', $id) }}" class="btn btn-secondary">
                            رجوع
                        </a>

                    </form>

                </div>

            </div>
        </div>
    </div>
@endsection
