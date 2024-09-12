<?php

namespace App\Livewire\Web\Dashboard;

use Aaran\Entries\Models\Purchase;
use Aaran\Entries\Models\Sale;
use Aaran\Master\Models\Contact;
use Aaran\Transaction\Models\Transaction;
use App\Helper\ConvertTo;
use App\Livewire\Trait\CommonTraitNew;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Index extends Component
{
    use CommonTraitNew;

    public $transactions;
    public $entries;
    public $contacts;


    public function mount()
    {
        $this->transactions = $this->getTransactions();
        $this->entries = $this->getEntries();
    }

    public function getTransactions()
    {
        $first = date('Y-m-01');
        $last = date('Y-m-t');

        $total_sales = Sale::select(
            DB::raw("SUM(grand_total) as grand_total"),
        )
            ->where('acyear', '=', session()->get('acyear'))
            ->where('company_id', '=', session()->get('company_id'))
            ->firstOrFail();

        $month_sales = Sale::select(
            DB::raw("SUM(grand_total) as grand_total"),
        )->where('acyear', '=', session()->get('acyear'))
            ->WhereBetween('invoice_date', [$first, $last])
            ->where('company_id', '=', session()->get('company_id'))
            ->firstOrFail();

        $total_purchase = Purchase::select(
            DB::raw("SUM(grand_total) as grand_total"),
        )->where('acyear', '=', session()->get('acyear'))
            ->where('company_id', '=', session()->get('company_id'))
            ->firstOrFail();

        $month_purchase = Purchase::select(
            DB::raw("SUM(grand_total) as grand_total"),
        )->where('acyear', '=', session()->get('acyear'))
            ->where('company_id', '=', session()->get('company_id'))
            ->WhereBetween('purchase_date', [$first, $last])
            ->firstOrFail();

        $total_receivable = Transaction::select(
            DB::raw("SUM(vname) as receipt_amount"),
        )->where('acyear', '=', session()->get('acyear'))
            ->where('mode_id', '=', 83)
            ->where('company_id', '=', session()->get('company_id'))
            ->firstOrFail();

        $month_receivable = Transaction::select(
            DB::raw("SUM(vname) as receipt_amount"),
        )->where('acyear', '=', session()->get('acyear'))
            ->where('mode_id', '=', 83)
            ->WhereBetween('vdate', [$first, $last])
            ->where('company_id', '=', session()->get('company_id'))
            ->firstOrFail();

        $total_payable = Transaction::select(
            DB::raw("SUM(vname) as payment_amount"),
        )->where('acyear', '=', session()->get('acyear'))
            ->where('mode_id', '=', 82)
            ->where('company_id', '=', session()->get('company_id'))
            ->firstOrFail();

        $month_payable = Transaction::select(
            DB::raw("SUM(vname) as payment_amount"),
        )->where('acyear', '=', session()->get('acyear'))
            ->where('mode_id', '=', 82)
            ->where('company_id', '=', session()->get('company_id'))
            ->WhereBetween('vdate', [$first, $last])
            ->firstOrFail();

        return Collection::make([
            'total_sales' => ConvertTo::rupeesFormat($total_sales->grand_total),
            'month_sales' => ConvertTo::rupeesFormat($month_sales->grand_total),
            'total_purchase' => ConvertTo::rupeesFormat($total_purchase->grand_total),
            'month_purchase' => ConvertTo::rupeesFormat($month_purchase->grand_total),
            'total_receivable' => ConvertTo::rupeesFormat($total_receivable->receipt_amount),
            'month_receivable' => ConvertTo::rupeesFormat($month_receivable->receipt_amount),
            'total_payable' => ConvertTo::rupeesFormat($total_payable->payment_amount),
            'month_payable' => ConvertTo::rupeesFormat($month_payable->payment_amount),
            'net_profit' => ConvertTo::rupeesFormat($total_sales->grand_total - $total_purchase->grand_total),
            'month_profit' => ConvertTo::rupeesFormat($month_sales->grand_total - $month_purchase->grand_total),
        ]);
    }

    public function getEntries()
    {
        $sales = Sale::latest()->first();
        $purchase = Purchase::latest()->first();
        $payment = Transaction::latest()->where('mode_id', '=', 82)->first();
        $receipt = Transaction::latest()->where('mode_id', '=', 83)->first();

        return Collection::make([
            'sales' => ConvertTo::rupeesFormat($sales->grand_total),
            'sales_no' => $sales->invoice_no,
            'sales_date' => $sales->invoice_date,
            'purchase' => ConvertTo::rupeesFormat($purchase->grand_total),
            'purchase_no' => $purchase->purchase_no,
            'purchase_date' => $purchase->purchase_date,
            'payment' => ConvertTo::rupeesFormat($payment->vname),
            'payment_date' => $payment->vdate,
            'receipt' => ConvertTo::rupeesFormat($receipt->vname),
            'receipt_date' => $receipt->vdate,
        ]);
    }

    public function getContact()
    {
        $this->contacts = Contact::all();
    }


    public function render()
    {
        $this->getContact();

        return view('livewire.web.dashboard.index');
    }
}
