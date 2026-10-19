@extends('layouts.app')

@section('title', 'إصدار بطاقة')
@section('page-title', 'إصدار بطاقة VIP جديدة')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="vip-panel p-4">
            <form method="POST" action="{{ route('cards.store') }}">
                @csrf
                <div class="mb-4">
                    <label class="form-label">العميل <span class="text-danger">*</span></label>
                    <select name="customer_id" class="form-select" required>
                        <option value="">— اختر العميل —</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }} — {{ $customer->phone }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">لا يوجد العميل؟ <a href="{{ route('customers.create') }}">أضف عميلاً جديداً</a></small>
                </div>

                <label class="form-label mb-3">نوع البطاقة <span class="text-danger">*</span></label>
                <div class="row g-3">
                    @foreach($cardTypes as $type)
                    <div class="col-md-6">
                        <div class="card h-100 {{ old('card_type', 'silver') === $type->value ? 'border-warning' : '' }}">
                            <div class="card-body">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="card_type"
                                           id="type_{{ $type->value }}" value="{{ $type->value }}"
                                           {{ old('card_type', 'silver') === $type->value ? 'checked' : '' }}>
                                    <label class="form-check-label w-100" for="type_{{ $type->value }}">
                                        <strong class="{{ $type->value === 'gold' ? 'text-warning' : '' }}">
                                            {{ $type->labelAr() }}
                                        </strong>
                                        <span class="badge bg-dark float-start">{{ $type->price() }} ₪</span>
                                        <ul class="small text-muted mt-2 mb-0 ps-3">
                                            @foreach($type->benefits() as $benefit)
                                                <li>{{ $benefit }}</li>
                                            @endforeach
                                        </ul>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-vip-gold"><i class="bi bi-credit-card"></i> إصدار البطاقة</button>
                    <a href="{{ route('cards.index') }}" class="btn btn-outline-secondary">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
