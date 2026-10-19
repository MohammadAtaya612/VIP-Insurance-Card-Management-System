@extends('layouts.app')

@section('title', 'حملة رسائل جديدة')
@section('page-title', 'إنشاء حملة رسائل جماعية')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="vip-panel p-4">
            <form method="POST" action="{{ route('messages.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">عنوان الحملة <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">قناة الإرسال <span class="text-danger">*</span></label>
                    <select name="channel" class="form-select" required>
                        <option value="sms" {{ old('channel') === 'sms' ? 'selected' : '' }}>SMS</option>
                        <option value="whatsapp" {{ old('channel') === 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                        <option value="both" {{ old('channel', 'both') === 'both' ? 'selected' : '' }}>SMS + WhatsApp</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">نص الرسالة <span class="text-danger">*</span></label>
                    <textarea name="message_body" class="form-control" rows="4" maxlength="1000" required>{{ old('message_body') }}</textarea>
                    <small class="text-muted">الحد الأقصى 1000 حرف</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">مصدر المستلمين <span class="text-danger">*</span></label>
                    <select name="source_type" class="form-select" id="sourceType" required>
                        <option value="customers" {{ old('source_type', 'customers') === 'customers' ? 'selected' : '' }}>
                            عملاء النظام
                        </option>
                        <option value="excel" {{ old('source_type') === 'excel' ? 'selected' : '' }}>
                            استيراد من Excel
                        </option>
                    </select>
                </div>

                <div class="mb-3" id="excelField" style="display: none;">
                    <label class="form-label">ملف Excel</label>
                    <input type="file" name="excel_file" class="form-control" accept=".xlsx,.xls,.csv">
                    <small class="text-muted">
                        الأعمدة المطلوبة: <code>name</code> (الاسم) و <code>phone</code> (الهاتف).
                        يدعم حتى 40,000 سجل.
                    </small>
                </div>

                <div class="mb-4">
                    <label class="form-label">جدولة الإرسال (اختياري)</label>
                    <input type="datetime-local" name="scheduled_at" class="form-control" value="{{ old('scheduled_at') }}">
                    <small class="text-muted">اتركه فارغاً للإرسال الفوري</small>
                </div>

                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i>
                    يتم الإرسال عبر Queue لدعم الأعداد الكبيرة. تأكد من تشغيل <code>php artisan queue:work</code>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-vip-gold"><i class="bi bi-send"></i> إرسال</button>
                    <a href="{{ route('messages.index') }}" class="btn btn-outline-secondary">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const sourceType = document.getElementById('sourceType');
    const excelField = document.getElementById('excelField');
    function toggleExcel() {
        excelField.style.display = sourceType.value === 'excel' ? 'block' : 'none';
    }
    sourceType.addEventListener('change', toggleExcel);
    toggleExcel();
</script>
@endpush
