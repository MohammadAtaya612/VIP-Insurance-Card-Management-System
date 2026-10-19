<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'national_id',
        'address',
        'notes',
    ];

    public function cards()
    {
        return $this->hasMany(VipCard::class);
    }

    public function activeCard()
    {
        return $this->hasOne(VipCard::class)->where('status', 'active')->latest();
    }

    public function messageLogs()
    {
        return $this->hasMany(MessageLog::class);
    }

    public function scopeSearch($query, ?string $term)
    {
        if (! $term) {
            return $query;
        }

        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
                ->orWhere('phone', 'like', "%{$term}%")
                ->orWhere('email', 'like', "%{$term}%")
                ->orWhere('national_id', 'like', "%{$term}%");
        });
    }
}
