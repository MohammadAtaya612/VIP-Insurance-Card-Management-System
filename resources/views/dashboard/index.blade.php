@extends('layouts.app')

@section('title', 'لوحة التحكم')
@section('page-title', 'لوحة التحكم')
@section('page-subtitle', 'نظرة عامة على أداء النظام')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-4 col-lg-2">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">العملاء</div>
                    <div class="stat-value">{{ number_format($stats['customers_count']) }}</div>
                </div>
                <div class="stat-icon stat-icon-navy"><i class="bi bi-people"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-2">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">بطاقات فعالة</div>
                    <div class="stat-value text-success">{{ number_format($stats['active_cards']) }}</div>
                </div>
                <div class="stat-icon stat-icon-green"><i class="bi bi-check-circle"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-2">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">بطاقات منتهية</div>
                    <div class="stat-value text-warning">{{ number_format($stats['expired_cards']) }}</div>
                </div>
                <div class="stat-icon stat-icon-gold"><i class="bi bi-clock-history"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-2">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Silver</div>
                    <div class="stat-value">{{ number_format($stats['silver_cards']) }}</div>
                </div>
                <div class="stat-icon stat-icon-blue"><i class="bi bi-award"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-2">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Gold</div>
                    <div class="stat-value" style="color: var(--vip-gold);">{{ number_format($stats['gold_cards']) }}</div>
                </div>
                <div class="stat-icon stat-icon-gold"><i class="bi bi-gem"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-2">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">الإيرادات</div>
                    <div class="stat-value">{{ number_format($stats['total_revenue']) }} ₪</div>
                </div>
                <div class="stat-icon stat-icon-gold"><i class="bi bi-currency-exchange"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="vip-panel">
            <div class="vip-panel-header">
                <h5><i class="bi bi-clock-history"></i> آخر البطاقات المصدرة</h5>
                <a href="{{ route('cards.create') }}" class="btn btn-vip-gold btn-sm">
                    <i class="bi bi-plus-lg"></i> إصدار بطاقة
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-vip table-hover mb-0">
                    <thead>
                        <tr>
                            <th>رقم العضوية</th>
                            <th>العميل</th>
                            <th>النوع</th>
                            <th>الحالة</th>
                            <th>التاريخ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stats['recent_cards'] as $card)
                        <tr>
                            <td><a href="{{ route('cards.show', $card) }}">{{ $card->membership_number }}</a></td>
                            <td>{{ $card->customer->name }}</td>
                            <td>
                                <span class="badge {{ $card->card_type->value === 'gold' ? 'bg-warning text-dark' : 'bg-secondary' }}">
                                    {{ $card->card_type->labelAr() }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $card->effectiveStatus()->badgeClass() }}">
                                    {{ $card->effectiveStatus()->label() }}
                                </span>
                            </td>
                            <td>{{ $card->issued_at->format('Y-m-d') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">لا توجد بطاقات بعد</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="vip-panel">
            <div class="vip-panel-header">
                <h5><i class="bi bi-lightning"></i> إجراءات سريعة</h5>
            </div>
            <div class="p-4 d-grid gap-2">
                <a href="{{ route('customers.create') }}" class="btn btn-outline-dark">
                    <i class="bi bi-person-plus"></i> إضافة عميل
                </a>
                <a href="{{ route('cards.create') }}" class="btn btn-vip-gold">
                    <i class="bi bi-credit-card"></i> إصدار بطاقة VIP
                </a>
                <a href="{{ route('messages.create') }}" class="btn btn-outline-primary">
                    <i class="bi bi-send"></i> رسالة جماعية
                </a>
            </div>
        </div>

        <div class="vip-panel mt-4">
            <div class="vip-panel-header">
                <h5><i class="bi bi-info-circle"></i> أنواع البطاقات</h5>
            </div>
            <div class="p-4">
                @foreach(config('vip.card_types') as $type => $info)
                <div class="mb-3 pb-3 border-bottom">
                    <strong class="{{ $type === 'gold' ? 'text-warning' : 'text-secondary' }}">
                        {{ $info['name_ar'] }}
                    </strong>
                    <span class="float-start badge bg-dark">{{ $info['price'] }} ₪</span>
                    <ul class="small text-muted mt-2 mb-0 ps-3">
                        @foreach($info['benefits'] as $benefit)
                            <li>{{ $benefit }}</li>
                        @endforeach
                    </ul>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
