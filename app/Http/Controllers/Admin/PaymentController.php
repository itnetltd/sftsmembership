<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $qStatus = (string) $request->get('status', '');
        $qMethod = (string) $request->get('method', '');
        $qSearch = (string) $request->get('q', '');

        $payments = Payment::with(['user']) // removed 'application'
            ->when($qStatus, fn ($q) => $q->where('status', $qStatus))
            ->when($qMethod, fn ($q) => $q->where('method', $qMethod))
            ->when($qSearch, function ($q) use ($qSearch) {
                $q->where(function ($sub) use ($qSearch) {
                    $sub->whereHas('user', function ($u) use ($qSearch) {
                        $u->where('email', 'like', "%{$qSearch}%")
                          ->orWhere('name', 'like', "%{$qSearch}%");
                    })
                    // use 'reference' instead of the non-existent 'transaction_id'
                    ->orWhere('reference', 'like', "%{$qSearch}%")
->orWhere('method', 'like', "%{$qSearch}%")
->orWhere('status', 'like', "%{$qSearch}%");

                });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $totals = [
            'count'     => Payment::count(),
            'completed' => Payment::where('status', 'completed')->sum('amount'),
            'pending'   => Payment::where('status', 'pending')->sum('amount'),
            'failed'    => Payment::where('status', 'failed')->sum('amount'),
        ];

        $methods = Payment::select('method')->distinct()->pluck('method')->filter()->values();

        return view('admin.payments.index', compact('payments', 'totals', 'methods', 'qStatus', 'qMethod', 'qSearch'));
    }

    public function show(Payment $payment)
    {
        $payment->load(['user']); // removed 'application'
        return view('admin.payments.show', compact('payment'));
    }

    public function updateStatus(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,failed,refunded',
        ]);

        $payment->status = $request->status;
        if ($request->status === 'completed' && is_null($payment->paid_at)) {
            $payment->paid_at = now();
        }
        $payment->save();

        return back()->with('ok', 'Payment status updated.');
    }

    public function export(Request $request): StreamedResponse
    {
        $file = 'payments_export_' . now()->format('Ymd_His') . '.csv';

        $query = Payment::with('user')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('method'), fn ($q) => $q->where('method', $request->method));

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$file}\"",
        ];

        return response()->stream(function () use ($query) {
            $out = fopen('php://output', 'w');
            // changed header to Reference
            fputcsv($out, ['ID', 'Date', 'User', 'Email', 'Method', 'Reference', 'Amount', 'Currency', 'Status', 'Paid At']);

            $query->orderByDesc('id')->chunk(500, function ($rows) use ($out) {
                foreach ($rows as $p) {
                    fputcsv($out, [
                        $p->id,
                        optional($p->created_at)->format('Y-m-d H:i'),
                        optional($p->user)->name,
                        optional($p->user)->email,
                        $p->method,
                        $p->reference, // use reference
                        number_format($p->amount, 2, '.', ''),
                        $p->currency,
                        $p->status,
                        optional($p->paid_at)->format('Y-m-d H:i'),
                    ]);
                }
            });

            fclose($out);
        }, 200, $headers);
    }
}
