<?php

namespace App\Http\Controllers;

use App\Models\CardUsage;
use App\Models\VipCard;
use Illuminate\Http\Request;

class CardUsageController extends Controller
{
    // قائمة الخدمات المتاحة
    public static array $services = [
        'ونش'             => 'ونش',
        'سيارة_بديلة'     => 'سيارة بديلة',
        'وقود'            => 'إيصال وقود',
        'اطار'            => 'إصلاح إطار',
        'بطارية'          => 'شحن بطارية',
        'زجاج'            => 'مشاركة زجاج ومرايا',
        'تامين_سفر'       => 'شراء تأمين سفر',
        'استشارة_قانونية' => 'استشارة قانونية',
        'اخرى'            => 'أخرى',
    ];

    public function store(Request $request, VipCard $card)
    {
        $data = $request->validate([
            'service_type' => ['required', 'string', 'max:100'],
            'cost'         => ['required', 'numeric', 'min:0'],
            'notes'        => ['nullable', 'string', 'max:500'],
            'used_at'      => ['nullable', 'date'],
        ]);

        $card->usages()->create([
            'service_type' => $data['service_type'],
            'cost'         => $data['cost'],
            'notes'        => $data['notes'] ?? null,
            'used_at'      => $data['used_at'] ?? now(),
            'recorded_by'  => auth()->id(),
        ]);

        return back()->with('success', 'تم تسجيل الاستخدام بنجاح.');
    }

    public function destroy(VipCard $card, CardUsage $usage)
    {
        $usage->delete();
        return back()->with('success', 'تم حذف السجل.');
    }
}