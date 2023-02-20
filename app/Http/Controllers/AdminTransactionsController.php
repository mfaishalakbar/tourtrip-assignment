<?php

namespace App\Http\Controllers;

use App\DataTables\PendingTransactionDataTable;
use App\DataTables\TransactionDataTable;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminTransactionsController extends Controller
{
    public function index(Request $request, TransactionDataTable $dataTable)
    {
        if ($request->user()->cannot('transaction:browse')) {
            return redirect()->route('dashboard');
        }

        return $dataTable->render('pages.admin.transactions.index');
    }

    public function indexPending(Request $request, PendingTransactionDataTable $dataTable)
    {
        if ($request->user()->cannot('transaction:browse') || $request->user()->cannot('transaction:approve')) {
            return redirect()->route('dashboard');
        }

        return $dataTable->render('pages.admin.transactions.index_pending');
    }

    public function view(Request $request, string $id)
    {
        if ($request->user()->cannot('transaction:read')) {
            return redirect()->route('dashboard');
        }

        $transactionData = Transaction::where('id', '=', $id)->first();
        if ($request->user()->customer != null && $transactionData->customer_id != $request->user()->customer->id) {
            return back();
        }

        $start = New \DateTime($transactionData->start_date . ' 00:00:00');
        $end = New \DateTime($transactionData->end_date . ' 00:00:00');
        $diff_date = $end->diff($start)->format("%a") + 1;


        return view('pages.admin.transactions.view', [
            'transaction' => $transactionData,
            'days' => $diff_date,
        ]);
    }

    public function delete(Request $request, string $id)
    {
        if ($request->user()->cannot('transaction:delete')) {
            return redirect()->route('dashboard');
        }

        $transactionData = Transaction::where('id', '=', $id)->first();
        if ($request->user()->customer != null && $transactionData->customer_id != $request->user()->customer->id) {
            return back();
        }

        $transactionData->status = 'REVOKED';
        $transactionData->save();
        return redirect()->route('transactions.index');
    }

    public function approve(Request $request, string $id)
    {
        if ($request->user()->cannot('transaction:delete')) {
            return redirect()->route('dashboard');
        }

        $transactionData = Transaction::where('id', '=', $id)->first();
        
        try {
            DB::beginTransaction();

            $transactionData->status = 'APPROVED';
            $transactionData->approved_at = new \DateTime();
            $transactionData->save();
            DB::commit();

            return redirect()->route('transactions.index');
        } catch (\PDOException $e) {
            dd($e);
            DB::rollBack();
        }

        return back();
    }
}
