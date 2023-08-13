@extends('layouts.app')
@section('style')
    <link rel="stylesheet" href="{{ asset('frontend/css/pickadate/classic.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/pickadate/classic.date.css') }}">
    @if (config('app.locale') == 'ar')
        <link rel="stylesheet" href="{{ asset('frontend/css/pickadate/rtl.css') }}">
    @endif
    <style>
        form.form label.error,
        label.error {
            color: red;
            font-style: italic;
        }
    </style>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2>{{ __('Frontend/frontend.invoice', ['invoice_number' => $invoice->invoice_number]) }}</h2>
                    <a href="{{ route('invoice.index') }}" class="btn btn-primary ml-auto"><i class="fa fa-home"></i>
                        {{ __('Frontend/frontend.back_to_invoice') }}</a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th>{{ __('frontend/frontend.customer_name') }}</th>
                                <td>{{ $invoice->customer_name }}</td>
                                <th>{{ __('frontend/frontend.customer_email') }}</th>
                                <td>{{ $invoice->customer_email }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('frontend/frontend.customer_mobile') }}</th>
                                <td>{{ $invoice->customer_mobile }}</td>
                                <th>{{ __('frontend/frontend.company_name') }}</th>
                                <td>{{ $invoice->company_name }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('frontend/frontend.invoice_number') }}</th>
                                <td>{{ $invoice->invoice_number }}</td>
                                <th>{{ __('Frontend/frontend.invoice_date') }}</th>
                                <td>{{ $invoice->invoice_date }}</td>
                            </tr>
                        </table>

                        <h3>{{ __('frontend/frontend.invoice_details') }}</h3>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>{{ __('frontend/frontend.product_name') }}</th>
                                    <th>{{ __('frontend/frontend.unit') }}</th>
                                    <th>{{ __('frontend/frontend.quantity') }}</th>
                                    <th>{{ __('frontend/frontend.unit_price') }}</th>
                                    <th>{{ __('frontend/frontend.product_subtotal') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoice->details as $item)
                                    <tr>
                                        <td width="5%">{{ $item->itration }}</td>
                                        <td width="35%">{{ $item->product_name }}</td>
                                        <td width="10%">{{ $item->unitText() }}</td>
                                        <td width="10%">{{ $item->quantity }}</td>
                                        <td width="10%">{{ $item->unit_price }}</td>
                                        <td>{{ $item->product_subtotal }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3"></td>
                                    <th colspan="2">{{ __('frontend/frontend.sub_total') }}</th>
                                    <td>{{ $invoice->sub_total }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <th colspan="2">{{ __('frontend/frontend.discount') }}</th>
                                    <td>{{ $invoice->discountResult() }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <th colspan="2">{{ __('frontend/frontend.vat') }}</th>
                                    <td>{{ $invoice->vat }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <th colspan="2">{{ __('frontend/frontend.shipping') }}</th>
                                    <td>{{ $invoice->shipping }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <th colspan="2">{{ __('frontend/frontend.total_due') }}</th>
                                    <td>{{ $invoice->total_due }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        window.print();
    </script>
@endsection
