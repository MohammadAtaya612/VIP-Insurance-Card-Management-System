@extends('layouts.app')

@section('title', 'تفاصيل الحملة')
@section('page-title', $campaign->title)

@section('content')
<div class="row g-4">
    <div class="col-lg-4">
        <div class="vip-panel p-4">
            <h5>معلومات الحملة</h5>
            <table class="table table-sm mt-3">
                <tr><th>القناة</th><td>{{ $campaign->channel->label() }}</td></tr>
                <tr><th>الحالة</th><td><span class="badge {{ $campaign->status->badgeClass() }}">{{ $campaign->status->label() }}</span></td></tr>
                <tr><th>المصدر</th><td>{{ $campaign->source_type === 'excel' ? 'Excel' : 'عملاء النظام' }}</td></tr>
                <tr><th>المستلمين</th><td>{{ number_format($campaign->total_recipients) }}</td></tr>
                <tr><th>مرسلة</th><td class="text-success">{{ $campaign->sent_count }}</td></tr>
                <tr><th>فاشلة</th><td class="text-danger">{{ $campaign->failed_count }}</td></tr>
                <tr><th>التقدم</th><td>{{ $campaign->progressPercent() }}%</td></tr>
                @if($campaign->scheduled_at)
                <tr><th>مجدولة</th><td>{{ $campaign->scheduled_at->format('Y-m-d H:i') }}</td></tr>
                @endif
                <tr><th>المنشئ</th><td>{{ $campaign->creator->name }}</td></tr>
            </table>

            <div class="progress mt-3" style="height: 8px;">
                <div class="progress-bar bg-success" style="width: {{ $campaign->progressPercent() }}%"></div>
            </div>
        </div>

        <div class="vip-panel p-4 mt-4">
            <h6>نص الرسالة</h6>
            <p class="text-muted mb-0">{{ $campaign->message_body }}</p>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="vip-panel">
            <div class="vip-panel-header">
                <h5>سجل الإرسال (آخر 100)</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-vip table-sm mb-0">
                    <thead>
                        <tr>
                            <th>الاسم</th>
                            <th>الهاتف</th>
                            <th>القناة</th>
                            <th>الحالة</th>
                            <th>الوقت</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($campaign->logs as $log)
                        <tr>
                            <td>{{ $log->recipient_name }}</td>
                            <td dir="ltr">{{ $log->recipient_phone }}</td>
                            <td>{{ $log->channel->label() }}</td>
                            <td>
                                @if($log->status === 'sent')
                                    <span class="badge bg-success">مرسلة</span>
                                @elseif($log->status === 'failed')
                                    <span class="badge bg-danger" title="{{ $log->error_message }}">فاشلة</span>
                                @else
                                    <span class="badge bg-secondary">معلقة</span>
                                @endif
                            </td>
                            <td>{{ $log->sent_at?->format('H:i:s') ?? '—' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-3">لا توجد سجلات</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
