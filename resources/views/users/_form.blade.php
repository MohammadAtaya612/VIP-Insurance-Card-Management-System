<div class="mb-3">
    <label class="form-label">الاسم</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" required>
</div>
<div class="mb-3">
    <label class="form-label">البريد الإلكتروني</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" required>
</div>
<div class="mb-3">
    <label class="form-label">كلمة المرور {{ isset($user) ? '(اتركها فارغة للإبقاء)' : '' }}</label>
    <input type="password" name="password" class="form-control" {{ isset($user) ? '' : 'required' }}>
</div>
<div class="mb-3">
    <label class="form-label">الصلاحية</label>
    <select name="role" class="form-select" required>
        @foreach($roles as $role)
            <option value="{{ $role->value }}" {{ old('role', isset($user) ? $user->role->value : 'employee') === $role->value ? 'selected' : '' }}>
                {{ $role->label() }}
            </option>
        @endforeach
    </select>
</div>
@if(isset($user))
<div class="form-check mb-3">
    <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active"
           {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active">حساب نشط</label>
</div>
@endif
