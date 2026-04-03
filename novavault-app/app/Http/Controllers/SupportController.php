<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use App\Models\TicketMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SupportController extends Controller
{
    public function index(Request $request): View
    {
        $tickets = SupportTicket::where('user_id', $request->user()->id)
            ->latest()
            ->paginate(15);

        return view('support.index', compact('tickets'));
    }

    public function create(): View
    {
        return view('support.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
            'priority' => ['sometimes', 'in:low,medium,high'],
        ]);

        $ticket = SupportTicket::create([
            'user_id' => $request->user()->id,
            'subject' => $validated['subject'],
            'priority' => $validated['priority'] ?? 'medium',
        ]);

        TicketMessage::create([
            'ticket_id' => $ticket->id,
            'user_id' => $request->user()->id,
            'body' => $validated['message'],
        ]);

        return redirect()->route('support.show', $ticket)
            ->with('status', 'Ticket created.');
    }

    public function show(Request $request, SupportTicket $ticket): View
    {
        // Users can only see their own tickets, admins can see all
        if ($ticket->user_id !== $request->user()->id && !$request->user()->isAdmin()) {
            abort(403);
        }

        $ticket->load('messages.user');

        return view('support.show', compact('ticket'));
    }

    public function reply(Request $request, SupportTicket $ticket): RedirectResponse
    {
        if ($ticket->user_id !== $request->user()->id && !$request->user()->isAdmin()) {
            abort(403);
        }

        $request->validate(['message' => ['required', 'string', 'max:5000']]);

        TicketMessage::create([
            'ticket_id' => $ticket->id,
            'user_id' => $request->user()->id,
            'body' => $request->message,
        ]);

        // Admin can update status
        if ($request->user()->isAdmin() && $request->filled('status')) {
            $ticket->update(['status' => $request->status]);
        }

        return back()->with('status', 'Reply sent.');
    }
}
