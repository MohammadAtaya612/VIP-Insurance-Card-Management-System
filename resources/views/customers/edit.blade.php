@extends('layouts.app')

@section('title', 'تعديل عميل')
@section('page-title', 'تعديل بيانات العميل')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="vip-panel p-4">
            <form method="POST" action="{{ route('customers.update', $customer) }}">
                @csrf @method('PUT')
                @include('customers._form', ['customer' => $customer])
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-vip-gold"><i class="bi bi-check-lg"></i> تحديث</button>
                    <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
