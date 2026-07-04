<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Project;
use App\Models\Contract;
use App\Models\Variation;
use App\Models\ActivityLog;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['project', 'contract', 'variation'])->latest()->get();
        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        $projects = Project::orderBy('name')->get();
        $contracts = Contract::orderBy('contract_number')->get();
        $variations = Variation::orderBy('variation_number')->get();
        return view('payments.create', compact('projects', 'contracts', 'variations'));
    }

    public function store(StorePaymentRequest $request)
    {
        $data = $request->validated();
        if (empty($data['total_amount'])) {
            $data['total_amount'] = ($data['amount'] ?? 0) + ($data['vat'] ?? 0);
        }
        $payment = Payment::create($data);

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'model_type'  => Payment::class,
            'model_id'    => $payment->id,
            'action'      => 'created',
            'description' => auth()->user()->name . ' created payment ' . $payment->invoice_number,
        ]);

        return redirect()->route('payments.index')
            ->with('success', 'Payment created successfully.');
    }

    public function show(Payment $payment)
    {
        $payment->load('project', 'contract', 'variation');
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $projects = Project::orderBy('name')->get();
        $contracts = Contract::orderBy('contract_number')->get();
        $variations = Variation::orderBy('variation_number')->get();
        return view('payments.edit', compact('payment', 'projects', 'contracts', 'variations'));
    }

    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        $data = $request->validated();
        if (empty($data['total_amount'])) {
            $data['total_amount'] = ($data['amount'] ?? 0) + ($data['vat'] ?? 0);
        }
        $payment->update($data);

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'model_type'  => Payment::class,
            'model_id'    => $payment->id,
            'action'      => 'updated',
            'description' => auth()->user()->name . ' updated payment ' . $payment->invoice_number,
        ]);

        return redirect()->route('payments.index')
            ->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        $invoiceNumber = $payment->invoice_number;
        $payment->delete();

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'model_type'  => Payment::class,
            'model_id'    => $payment->id,
            'action'      => 'deleted',
            'description' => auth()->user()->name . ' deleted payment ' . $invoiceNumber,
        ]);

        return redirect()->route('payments.index')
            ->with('success', 'Payment deleted successfully.');
    }
}