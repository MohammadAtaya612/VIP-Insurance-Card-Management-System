@extends('layouts.app')

@section('title', 'الرسائل الجماعية')
@section('page-title', 'الرسائل الجماعية')
@section('page-subtitle', 'إرسال SMS و WhatsApp جماعي')

@section('content')
<div class="vip-panel">
    <div class="vip-panel-header">
        <h5 class="mb-0">سجل الحملات</h5>
        <a href="{{ route('messages.create') }}" class="btn btn-vip-gold">
            <i class="bi bi-send"></i> حملة جديدة
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-vip table-hover mb-0">
            <thead>
                <tr>
                    <th>العنوان</th>
                    <th>القناة</th>
                    <th>الحالة</th>
                    <th>المستلمين</th>
                    <th>مرسلة / فاشلة</th>
                    <th>التاريخ</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($campaigns as $campaign)
                <tr>
                    <td><strong>{{ $campaign->title }}</strong></td>
                    <td>{{ $campaign->channel->label() }}</td>
                    <td><span class="badge {{ $campaign->status->badgeClass() }}">{{ $campaign->status->label() }}</span></td>
                    <td>{{ number_format($campaign->total_recipients) }}</td>
                    <td>
                        <span class="text-success">{{ $campaign->sent_count }}</span> /
                        <span class="text-danger">{{ $campaign->failed_count }}</span>
                    </td>
                    <td>{{ $campaign->created_at->format('Y-m-d H:i') }}</td>
                    <td>
                        <a href="{{ route('messages.show', $campaign) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">لا توجد حملات</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($campaigns->hasPages())
    <div class="p-3">{{ $campaigns->links() }}</div>
    @endif
</div>
@endsection
