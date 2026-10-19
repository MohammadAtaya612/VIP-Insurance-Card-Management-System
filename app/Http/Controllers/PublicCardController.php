<?php

namespace App\Http\Controllers;

use App\Models\VipCard;

class PublicCardController extends Controller
{
    public function show(string $token)
    {
            $card = VipCard::with(['customer', 'usages'])
            ->where('qr_token', $token)
            ->firstOrFail();

        $status = $card->effectiveStatus();

        return view('public.card', compact('card', 'status'));
    }
}
