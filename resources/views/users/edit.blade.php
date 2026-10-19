@extends('layouts.app')

@section('title', 'تعديل مستخدم')
@section('page-title')
تعديل: {{ $user->name }}
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="vip-panel p-4">
            <form method="POST" action="{{ route('users.update', $user) }}">
                @csrf @method('PUT')
                @include('users._form', ['user' => $user])
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-vip-gold">تحديث</button>
                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
