@extends('layouts.app')

@section('title', 'البطاقات')
@section('page-title', 'إدارة البطاقات')
@section('page-subtitle', 'إصدار وتجديد وإدارة بطاقات VIP')

@section('content')
<div class="vip-panel">
    <div class="vip-panel-header">
        <form class="search-box d-flex" method="GET">
            <input type="text" name="q" class="form-control" placeholder="بحث برقم العضوية أو اسم العميل..." value="{{ request('q') }}">
            <button class="btn btn-vip-primary" type="submit"><i class="bi bi-search"></i></button>
        </form>
        <a href="{{ route('cards.create') }}" class="btn btn-vip-gold">
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
                    <th>السعر</th>
                    <th>الحالة</th>
                    <th>تاريخ الانتهاء</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cards as $card)
                <tr>
                    <td><strong>{{ $card->membership_number }}</strong></td>
                    <td>{{ $card->customer->name }}</td>
                    <td>
                        <span class="badge {{ $card->card_type->value === 'gold' ? 'bg-warning text-dark' : 'bg-secondary' }}">
                            {{ $card->card_type->labelAr() }}
                        </span>
                    </td>
                    <td>{{ number_format($card->price) }} ₪</td>
                    <td>
                        <span class="badge {{ $card->effectiveStatus()->badgeClass() }}">
                            {{ $card->effectiveStatus()->label() }}
                        </span>
                    </td>
                    <td>{{ $card->expires_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('cards.show', $card) }}" class="btn btn-sm btn-vip-primary">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">لا توجد بطاقات</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($cards->hasPages())
    <div class="p-3">{{ $cards->links() }}</div>
    @endif
</div>
@endsection
