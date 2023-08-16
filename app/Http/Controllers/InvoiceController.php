<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Mail\SendInvoice;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $invoices = Invoice::orderBy('id', 'desc')->paginate(10);
        return view('front.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('front.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data['customer_name'] = $request->customer_name;
        $data['customer_email'] =  $request->customer_email;
        $data['customer_mobile'] = $request->customer_mobile;
        $data['company_name'] =   $request->company_name;
        $data['invoice_number'] = $request->invoice_number;
        $data['invoice_date'] = $request->invoice_date;
        $data['sub_total'] = $request->sub_total;
        $data['discount_type'] = $request->discount_type;
        $data['discount_value'] = $request->discount_value;
        $data['vat_value'] = $request->vat_value;
        $data['shipping'] = $request->shipping;
        $data['total_due'] = $request->total_due;

        $invoice = Invoice::create($data);

        $details_list = [];

        $details_list = [];
        for ($i = 0; $i < count($request->product_name); $i++) {
            $details_list[$i]['product_name'] = $request->product_name[$i];
            $details_list[$i]['unit'] = $request->unit[$i];
            $details_list[$i]['quantity'] = $request->quantity[$i];
            $details_list[$i]['unit_price'] = $request->unit_price[$i];
            $details_list[$i]['row_sub_total'] = $request->row_sub_total[$i];
        }

        $details = $invoice->details()->createMany($details_list);

        if ($details) {
            return redirect()->back()->with([
                'message' => __('Frontend/frontend.created_successfully'),
                'alert-type' => 'success'
            ]);
        } else {
            return redirect()->back()->with([
                'message' => __('Frontend/frontend.created_failed'),
                'alert-type' => 'danger'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $invoice = Invoice::findOrFail($id);
        return view('front.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $invoice = Invoice::findOrFail($id);
        return view('front.edit', compact('invoice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

        $invoice = Invoice::whereId($id)->first();

        $data['customer_name'] = $request->customer_name;
        $data['customer_email'] =  $request->customer_email;
        $data['customer_mobile'] = $request->customer_mobile;
        $data['company_name'] =   $request->company_name;
        $data['invoice_number'] = $request->invoice_number;
        $data['invoice_date'] = $request->invoice_date;
        $data['sub_total'] = $request->sub_total;
        $data['discount_type'] = $request->discount_type;
        $data['discount_value'] = $request->discount_value;
        $data['vat_value'] = $request->vat_value;
        $data['shipping'] = $request->shipping;
        $data['total_due'] = $request->total_due;

        $invoice->update($data);

        $invoice->details()->delete();

        $details_list = [];
        for ($i = 0; $i < count($request->product_name); $i++) {
            $details_list[$i]['product_name'] = $request->product_name[$i];
            $details_list[$i]['unit'] = $request->unit[$i];
            $details_list[$i]['quantity'] = $request->quantity[$i];
            $details_list[$i]['unit_price'] = $request->unit_price[$i];
            $details_list[$i]['row_sub_total'] = $request->row_sub_total[$i];
        }

        $details = $invoice->details()->createMany($details_list);


        if ($details) {
            return redirect()->back()->with([
                'message' => __('frontend/frontend.updated_successfully'),
                'alert-type' => 'success'
            ]);
        } else {
            return redirect()->back()->with([
                'message' => __('frontend/frontend.updated_failed'),
                'alert-type' => 'danger'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $invoice = Invoice::findOrFail($id);

        if ($invoice) {
            $invoice->delete();
            return redirect()->route('invoice.index')->with([
                'message' =>  __('Frontend/frontend.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        } else {
            return redirect()->route('invoice.index')->with([
                'message' => __('Frontend/frontend.deleted_failed'),
                'alert-type' => 'danger'
            ]);
        }
    }


    public function print($id)
    {
        $invoice = Invoice::findOrFail($id);
        return view('front.print', compact('invoice'));
    }

    public function pdf($id)
    {
        $invoice = Invoice::findOrFail($id)->first();

        $data['invoice_id']  = $invoice->invoice_id;
        $data['invoice_date'] = $invoice->invoice_date;
        $data['customer'] = [
            __('frontend/frontend.customer_name') => $invoice->customer_name,
            __('frontend/frontend.customer_mobile')  => $invoice->customer_mobile,
            __('frontend/frontend.customer_email') => $invoice->customer_email,
        ];

        $items = [];

        $invoice_details = $invoice->details()->get();

        foreach ($invoice_details as $item) {
            $items[] = [
                'product_name' => $item->product_name,
                'unit' => $item->unitText(),
                'quantity' => $item->quantity,
                'unit_price' => $item->unitPrice,
                'row_sub_total'     => $item->row_sub_total,
            ];
        }

        $data['items'] = $items;

        $data['invoice_number']     = $invoice->invoice_number;
        $data['created_at'] = $invoice->created_at->format('Y-m-d');
        $data['sub_total']  = $invoice->sub_total;
        $data['discount'] = $invoice->discountResult();
        $data['vat_value'] = $invoice->vat_value;
        $data['shipping']  = $invoice->shipping;
        $data['total_due'] = $invoice->total_due;


        
    }

    public function send_to_email($id)
    {
        $invoice = Invoice::whereId($id)->first();

        $this->pdf($id);

        Mail::to($invoice->customer_email)->locale(config('app.locale'))->send(new SendInvoice($invoice));

        return redirect()->route('front.index')->with([
            'message' => __('frontend/frontend.sent_successfully'),
            'alert-type' => 'success',
        ]);

    }
}
