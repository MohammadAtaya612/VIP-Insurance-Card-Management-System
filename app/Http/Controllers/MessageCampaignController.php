<?php

namespace App\Http\Controllers;

use App\Models\MessageCampaign;
use App\Services\MessageCampaignService;
use Illuminate\Http\Request;

class MessageCampaignController extends Controller
{
    public function __construct(private MessageCampaignService $campaignService) {}

    public function index()
    {
        $campaigns = MessageCampaign::with('creator')
            ->latest()
            ->paginate(15);

        return view('messages.index', compact('campaigns'));
    }

    public function create()
    {
        return view('messages.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'channel' => ['required', 'in:sms,whatsapp,both'],
            'message_body' => ['required', 'string', 'max:1000'],
            'source_type' => ['required', 'in:customers,excel'],
            'scheduled_at' => ['nullable', 'date', 'after:now'],
            'excel_file' => ['nullable', 'file', 'mimes:xlsx,xls,csv', 'max:51200'],
        ]);

        $campaign = $this->campaignService->create($data, $request->user());

        if ($data['source_type'] === 'excel' && $request->hasFile('excel_file')) {
            $this->campaignService->importRecipients($campaign, $request->file('excel_file'));
        } else {
            $this->campaignService->loadFromCustomers($campaign);
        }

        if (! empty($data['scheduled_at'])) {
            $this->campaignService->schedule($campaign);

            return redirect()->route('messages.index')
                ->with('success', 'تم جدولة الحملة بنجاح.');
        }

        $this->campaignService->dispatch($campaign);

        return redirect()->route('messages.index')
            ->with('success', 'بدأ إرسال الرسائل.');
    }

    public function show(MessageCampaign $message)
    {
        $message->load(['creator', 'logs' => fn ($q) => $q->latest()->limit(100)]);

        return view('messages.show', ['campaign' => $message]);
    }
}
