<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class EventController extends Controller
{
    public function index(Request $request, String $slug): View {
        $event = Event::fetch($slug);
        return view('frontend.details', compact('event'));
    }

    public function toHome(): RedirectResponse {
        return redirect(route('home'));
    }

    public function toEventPage($slug): RedirectResponse {
        return redirect(route('detail', $slug));
    }

    public function checkout(Request $request, $slug): View {
        $event = Event::fetch($slug);
        $selectedTickets = collect($request->tickets)->filter(function ($quantity) {return $quantity > 0;});
        $tickets = $selectedTickets->map(function ($quantity, $id) {
            $ticket = Ticket::find($id);
            return $ticket ? (object) [
                'name' => $ticket->name,
                'quantity' => (int) $quantity,
                'price' => $ticket->price,
                'total' => $ticket->price * $quantity,
            ] : null;
        })->filter();

        $uniquePrice = round(rand(0, 100) / 2000 * $tickets->sum('total'), 1);
        $tax = 0.1 * $tickets->sum('total');
        $totalPrice = $tickets->sum('total') + $tax - $uniquePrice;

        $request->session()->put('event', $event);
        $request->session()->put('tickets', $tickets);
        $request->session()->put('uniquePrice', $uniquePrice);
        $request->session()->put('totalPrice', $totalPrice);

        return view('frontend.checkout', compact('event', 'tickets', 'uniquePrice', 'tax', 'totalPrice'));
    }

    public function checkoutPay(Request $request): RedirectResponse {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'payment_method' => 'required|string|in:manual_transfer,virtual_account,credit_card,my_wallet'
        ]);

        $event = $request->session()->get('event');
        $tickets = $request->session()->get('tickets');
        $uniquePrice = $request->session()->get('uniquePrice');
        $totalPrice = $request->session()->get('totalPrice');

        $transaction = Transaction::create([
            'code' => 'TRX' . mt_rand(100000, 999999),
            'event_id' => $event->id,
            'name' => $request->name,
            'email' => $request->email,
            'status' => 'pending',
            'unique_price' => $uniquePrice,
            'total_price' => $totalPrice,
            'payment_method' => $request->payment_method,
        ]);

        foreach ($tickets as $ticket) {
            $transaction->transactionDetails()->create([
                'code' => 'TIX' . mt_rand(100000, 999999),
                'ticket_id' => Ticket::where('name', $ticket->name)->first()->id,
                'transaction_id' => $transaction->id,
                'is_redeemed' => false,
            ]);
        }

        return redirect()->route('checkout-success');
    }

    public function checkoutSuccess(): View {
        return view('frontend.checkout-success');
    }
}
