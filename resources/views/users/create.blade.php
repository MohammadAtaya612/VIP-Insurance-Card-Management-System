@extends('layouts.app')

@section('title', 'مستخدم جديد')
@section('page-title', 'إضافة مستخدم')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="vip-panel p-4">
            <form method="POST" action="{{ route('users.store') }}">
                @csrf
                @include('users._form')
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-vip-gold">حفظ</button>
                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
