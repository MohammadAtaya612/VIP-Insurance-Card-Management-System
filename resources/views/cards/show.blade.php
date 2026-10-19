@extends('layouts.app')

@section('title', 'عرض البطاقة')
@section('page-title')
بطاقة VIP — {{ $card->membership_number }}
@endsection

@section('content')
<div class="row g-4">
    <div class="col-lg-5">
        <div class="vip-panel p-4 text-center">
          <div class="vip-card-visual {{ $card->card_type->value }} mx-auto mb-3">
    <div class="card-logo">
        <i class="bi bi-shield-check"></i> {{ config('vip.company_name') }}
    </div>
    <div class="card-type">{{ $card->card_type->label() }}</div>
    <div class="card-member">
        <div>{{ $card->customer->name }}</div>
        <div class="card-number">{{ $card->membership_number }}</div>
    </div>
    <div class="card-expiry">صالحة حتى: {{ $card->expires_at->format('d/m/Y') }}</div>
    <div class="card-qr">{!! $qrSvg !!}</div>
</div>

            <span class="badge {{ $card->effectiveStatus()->badgeClass() }} fs-6">
                {{ $card->effectiveStatus()->label() }}
            </span>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="vip-panel p-4">
            <h5 class="mb-4">تفاصيل البطاقة</h5>
            <table class="table">
                <tr><th width="35%">العميل</th><td>{{ $card->customer->name }}</td></tr>
                <tr><th>الهاتف</th><td dir="ltr">{{ $card->customer->phone }}</td></tr>
                <tr><th>نوع البطاقة</th><td>{{ $card->card_type->labelAr() }}</td></tr>
                <tr><th>السعر</th><td>{{ number_format($card->price) }} ₪</td></tr>
                <tr><th>تاريخ الإصدار</th><td>{{ $card->issued_at->format('Y-m-d H:i') }}</td></tr>
                <tr><th>تاريخ الانتهاء</th><td>{{ $card->expires_at->format('Y-m-d') }}</td></tr>
                <tr><th>أصدرها</th><td>{{ $card->issuer->name }}</td></tr>
                <tr><th>رابط QR</th><td><a href="{{ $card->qrUrl() }}" target="_blank">{{ $card->qrUrl() }}</a></td></tr>
            </table>

            <h6 class="mt-4">المزايا</h6>
            <ul>
                @foreach($card->benefits() as $benefit)
                    <li>{{ $benefit }}</li>
                @endforeach
            </ul>

            <div class="d-flex flex-wrap gap-2 mt-4">
                <a href="{{ route('cards.pdf', $card) }}" class="btn btn-vip-primary">
                    <i class="bi bi-file-pdf"></i> تحميل PDF
                </a>
                <form action="{{ route('cards.whatsapp', $card) }}" method="POST">
                    @csrf
                    <button class="btn btn-success"><i class="bi bi-whatsapp"></i> إرسال WhatsApp</button>
                </form>
                @if($card->effectiveStatus()->value !== 'cancelled')
                <form action="{{ route('cards.renew', $card) }}" method="POST"
                      onsubmit="return confirm('تجديد البطاقة لمدة سنة إضافية؟')">
                    @csrf
                    <button class="btn btn-warning"><i class="bi bi-arrow-repeat"></i> تجديد</button>
                </form>
                <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#cancelModal">
                    <i class="bi bi-x-circle"></i> إلغاء
                </button>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('cards.cancel', $card) }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">إلغاء البطاقة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <label class="form-label">سبب الإلغاء (اختياري)</label>
                <textarea name="cancelled_reason" class="form-control" rows="3"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">تراجع</button>
                <button type="submit" class="btn btn-danger">تأكيد الإلغاء</button>
            </div>
        </form>
    </div>
</div>

{{-- سجل الاستخدام --}}
<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-clock-history"></i> سجل الاستخدام</h5>
        <button class="btn btn-sm btn-warning" data-bs-toggle="collapse" data-bs-target="#addUsageForm">
            <i class="bi bi-plus-lg"></i> تسجيل استخدام
        </button>
    </div>

    {{-- فورم إضافة استخدام --}}
    <div class="collapse" id="addUsageForm">
        <div class="card-body border-bottom bg-light">
            <form method="POST" action="{{ route('cards.usages.store', $card) }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">نوع الخدمة</label>
                        <select name="service_type" class="form-select" required>
                            <option value="">-- اختر الخدمة --</option>
                            @foreach(\App\Http\Controllers\CardUsageController::$services as $key => $label)
                                <option value="{{ $label }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">التكلفة (₪)</label>
                        <input type="number" name="cost" class="form-control" min="0" step="0.01" value="0" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">التاريخ</label>
                        <input type="date" name="used_at" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-check-lg"></i> حفظ
                        </button>
                    </div>
                    <div class="col-12">
                        <label class="form-label">ملاحظات</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="أي تفاصيل إضافية..."></textarea>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- جدول السجلات --}}
    <div class="card-body p-0">
        @if($card->usages->isEmpty())
            <div class="text-center text-muted py-4">
                <i class="bi bi-inbox" style="font-size:2rem;"></i>
                <p class="mt-2">لا توجد استخدامات مسجلة بعد</p>
            </div>
        @else
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>الخدمة</th>
                        <th>التكلفة</th>
                        <th>التاريخ</th>
                        <th>سجّل بواسطة</th>
                        <th>ملاحظات</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($card->usages as $usage)
                    <tr>
                        <td><span class="badge bg-warning text-dark">{{ $usage->service_type }}</span></td>
                        <td>₪ {{ number_format($usage->cost, 2) }}</td>
                        <td>{{ $usage->used_at->format('d/m/Y') }}</td>
                        <td>{{ $usage->recorder?->name ?? 'العميل' }}</td>
                        <td class="text-muted small">{{ $usage->notes ?? '—' }}</td>
                        <td>
                            @auth
                            <form method="POST" action="{{ route('cards.usages.destroy', [$card, $usage]) }}" onsubmit="return confirm('حذف هذا السجل؟')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                            @endauth
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th>الإجمالي</th>
                        <th>₪ {{ number_format($card->usages->sum('cost'), 2) }}</th>
                        <th colspan="4"></th>
                    </tr>
                </tfoot>
            </table>
        @endif
    </div>
</div>
@endsection
