@extends('layouts.app')

@section('title', 'العملاء')
@section('page-title', 'إدارة العملاء')
@section('page-subtitle', 'عرض وإدارة بيانات العملاء')

@section('content')
<div class="vip-panel">
    <div class="vip-panel-header">
        <form class="search-box d-flex" method="GET">
            <input type="text" name="q" class="form-control" placeholder="بحث بالاسم، الهاتف، البريد..." value="{{ request('q') }}">
            <button class="btn btn-vip-primary" type="submit"><i class="bi bi-search"></i></button>
        </form>
        <a href="{{ route('customers.create') }}" class="btn btn-vip-gold">
            <i class="bi bi-person-plus"></i> إضافة عميل
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-vip table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>الهاتف</th>
                    <th>البريد</th>
                    <th>البطاقات</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                <tr>
                    <td>{{ $customer->id }}</td>
                    <td><strong>{{ $customer->name }}</strong></td>
                    <td dir="ltr" class="text-end">{{ $customer->phone }}</td>
                    <td>{{ $customer->email ?? '—' }}</td>
                    <td><span class="badge bg-info">{{ $customer->cards_count }}</span></td>
                    <td>
                        <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('هل أنت متأكد من حذف هذا العميل؟')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">لا يوجد عملاء</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($customers->hasPages())
    <div class="p-3">{{ $customers->links() }}</div>
    @endif
</div>
@endsection
