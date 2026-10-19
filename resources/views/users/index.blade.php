@extends('layouts.app')

@section('title', 'المستخدمين')
@section('page-title', 'إدارة المستخدمين')
@section('page-subtitle', 'Admin فقط')

@section('content')
<div class="vip-panel">
    <div class="vip-panel-header">
        <h5 class="mb-0">قائمة المستخدمين</h5>
        <a href="{{ route('users.create') }}" class="btn btn-vip-gold">
            <i class="bi bi-person-plus"></i> مستخدم جديد
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-vip table-hover mb-0">
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>البريد</th>
                    <th>الصلاحية</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge {{ $user->isAdmin() ? 'bg-warning text-dark' : 'bg-info' }}">
                            {{ $user->role->label() }}
                        </span>
                    </td>
                    <td>
                        <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-danger' }}">
                            {{ $user->is_active ? 'نشط' : 'معطل' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        @if($user->id !== auth()->id())
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('حذف المستخدم؟')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="p-3">{{ $users->links() }}</div>
    @endif
</div>
@endsection
