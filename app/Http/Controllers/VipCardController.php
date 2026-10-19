<?php

namespace App\Http\Controllers;

use App\Enums\CardType;
use App\Models\Customer;
use App\Models\VipCard;
use App\Services\VipCardService;
use App\Services\WhatsAppService;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Mpdf\Mpdf;
class VipCardController extends Controller
{
    public function __construct(
        private VipCardService $cardService,
        private WhatsAppService $whatsapp
    ) {}

    public function index(Request $request)
    {
        $cards = VipCard::with(['customer', 'issuer'])
            ->search($request->q)
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('cards.index', compact('cards'));
    }

    public function create()
    {
       $customers = Customer::orderBy('name')->get();
        $cardTypes = CardType::cases();

        return view('cards.create', compact('customers', 'cardTypes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'card_type' => ['required', 'in:silver,gold'],
        ]);

        $customer = Customer::findOrFail($data['customer_id']);
        $card = $this->cardService->issue(
            $customer,
            CardType::from($data['card_type']),
            $request->user()
        );

        return redirect()->route('cards.show', $card)
            ->with('success', 'تم إصدار البطاقة بنجاح.');
    }

    public function show(VipCard $card)
    {
        $card->load(['customer', 'issuer']);
        $qrSvg = QrCode::size(150)->generate($card->qrUrl());

        return view('cards.show', compact('card', 'qrSvg'));
    }

    public function renew(VipCard $card)
    {
        $this->cardService->renew($card);

        return back()->with('success', 'تم تجديد البطاقة بنجاح.');
    }

    public function cancel(Request $request, VipCard $card)
    {
        $data = $request->validate([
            'cancelled_reason' => ['nullable', 'string', 'max:500'],
        ]);

        $this->cardService->cancel($card, $data['cancelled_reason'] ?? null);

        return back()->with('success', 'تم إلغاء البطاقة.');
    }

public function pdf(VipCard $card)
{
    $card->load('customer');
    $qrSvg = QrCode::size(120)->generate($card->qrUrl());

    $html = view('cards.pdf', compact('card', 'qrSvg'))->render();

    $tempDir = storage_path('app/mpdf-temp');
    if (!file_exists($tempDir)) {
        mkdir($tempDir, 0755, true);
    }

    $mpdf = new Mpdf([
        'mode'          => 'utf-8',
        'format'        => [160, 100],
        'margin_top'    => 0,
        'margin_bottom' => 0,
        'margin_left'   => 0,
        'margin_right'  => 0,
        'tempDir'       => $tempDir,
    ]);

    $mpdf->WriteHTML($html);

    $filename = "vip-card-{$card->membership_number}.pdf";

    return response($mpdf->Output($filename, 'S'), 200, [
        'Content-Type'        => 'application/pdf',
        'Content-Disposition' => "attachment; filename=\"{$filename}\"",
    ]);
}

private function fixArabic(string $text): string
{
    // عكس الكلمات العربية لتصحيح اتجاه dompdf
    $words = explode(' ', $text);
    $reversed = array_reverse($words);
    return implode(' ', $reversed);
}

    public function sendWhatsapp(VipCard $card)
    {
        $success = $this->whatsapp->sendCardLink($card->load('customer'));

        if ($success) {
            return back()->with('success', 'تم إرسال البطاقة عبر WhatsApp.');
        }

        $message = sprintf(
            "مرحباً %s، بطاقتك VIP جاهزة! %s",
            $card->customer->name,
            $card->qrUrl()
        );

        return redirect()->away(
            $this->whatsapp->getShareUrl($card->customer->phone, $message)
        );
    }
}
