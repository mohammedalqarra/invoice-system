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

                        <h3>{{  __('frontend/frontend.invoice_details') }}</h3>

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
                                        <th>{{ $item->itration }}</th>
                                        <th>{{ $item->product_name  }}</th>
                                        <th>{{ $item->unitText() }}</th>
                                        <th>{{ $item->quantity }}</th>
                                        <th>{{ $item->unit_price }}</th>
                                        <th>{{ $item->product_subtotal }}</th>
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
                                        <th colspan="2">{{ __('frontend/frontend.discount')}}</th>
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
                                    <th colspan="2">{{ __('frontend/frontend.total_due')}}</th>
                                    <td>{{ $invoice->total_due }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-12 text-center">
                            <a href="{{ route('invoice.print' , $invoice->id) }}" class="btn btn-primary btn-sm ml-auto"><i class="fa fa-print"></i>{{ __('frontend/frontend.print') }}</a>
                            <a href="{{ route('invoice.pdf' , $invoice->id) }}" class="btn btn-secondary   btn-sm ml-auto"><i class="fa fa-file-pdf"></i>{{ __('frontend/frontend.export_pdf') }}</a>
                            <a href="" class="btn btn-success  btn-sm ml-auto"><i class="fa fa-envelope"></i>{{ __('frontend/frontend.send_to_email') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('frontend/js/form_validation/jquery.form.js') }}"></script>
    <script src="{{ asset('frontend/js/form_validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('frontend/js/form_validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('frontend/js/pickadate/picker.js') }}"></script>
    <script src="{{ asset('frontend/js/pickadate/picker.date.js') }}"></script>
    @if (config('app.locale') == 'ar')
        <script src="{{ asset('frontend/js/form_validation/messages_ar.js') }}"></script>
        <script src="{{ asset('frontend/js/pickadate/ar.js') }}"></script>
    @endif
    <script src="{{ asset('frontend/js/custom.js') }}"></script>
@endsection
