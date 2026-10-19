<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بطاقة VIP — {{ $card->membership_number }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="public-card-page">
        <div class="public-card-container">
            <div class="text-center mb-4">
                <i class="bi bi-shield-check text-warning" style="font-size: 2.5rem;"></i>
                <h4 class="text-white mt-2">{{ config('vip.company_name') }}</h4>
                <p class="text-white-50">التحقق من بطاقة العضوية</p>
            </div>

            <div class="vip-panel p-4">
                <div class="text-center mb-4">
                    <span class="badge {{ $status->badgeClass() }} fs-5 px-4 py-2">
                        <i class="bi bi-{{ $status->value === 'active' ? 'check-circle' : ($status->value === 'expired' ? 'clock' : 'x-circle') }}"></i>
                        {{ $status->label() }}
                    </span>
                </div>

                <table class="table">
                    <tr>
                        <th class="text-muted" width="40%">اسم العميل</th>
                        <td><strong>{{ $card->customer->name }}</strong></td>
                    </tr>
                    <tr>
                        <th class="text-muted">نوع البطاقة</th>
                        <td>
                            <span class="badge {{ $card->card_type->value === 'gold' ? 'bg-warning text-dark' : 'bg-secondary' }}">
                                {{ $card->card_type->labelAr() }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-muted">رقم العضوية</th>
                        <td><code>{{ $card->membership_number }}</code></td>
                    </tr>
                    <tr>
                        <th class="text-muted">تاريخ الانتهاء</th>
                        <td>{{ $card->expires_at->format('d/m/Y') }}</td>
                    </tr>
                </table>

                <h6 class="mt-4 mb-3"><i class="bi bi-star"></i> المزايا المتاحة</h6>
                <ul class="list-group list-group-flush">
                    @foreach($card->benefits() as $benefit)
                    <li class="list-group-item d-flex align-items-center gap-2">
                        <i class="bi bi-check-circle-fill text-success"></i>
                        {{ $benefit }}
                    </li>
                    @endforeach
                </ul>
            </div>
{{-- سجل الاستخدام للعميل --}}
@if($card->usages && $card->usages->count() > 0)
<div class="vip-panel p-4 mt-3">
    <h6 class="mb-3"><i class="bi bi-clock-history text-warning"></i> سجل الاستخدامات</h6>
    <table class="table table-sm">
        <thead>
            <tr>
                <th>الخدمة</th>
                <th>التاريخ</th>
            </tr>
        </thead>
        <tbody>
            @foreach($card->usages as $usage)
            <tr>
                <td><span class="badge bg-warning text-dark">{{ $usage->service_type }}</span></td>
                <td>{{ $usage->used_at->format('d/m/Y') }}</td>
            </tr>
            @if($usage->notes)
            <tr>
                <td colspan="2" class="text-muted small ps-3">
                    <i class="bi bi-chat-left-text"></i> {{ $usage->notes }}
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
</div>
@endif
            <p class="text-center text-white-50 mt-4 small">
                © {{ date('Y') }} {{ config('vip.company_name') }} — جميع الحقوق محفوظة
            </p>
        </div>
    </div>
</body>
</html>
