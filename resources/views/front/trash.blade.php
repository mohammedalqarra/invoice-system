@extends('layouts.app')

@section('style')
    <style>
        a {
            text-decoration: none;
            color: #000;
            font-weight: bold;
            padding: 10px;
        }
    </style>
@endsection
@section('content')

    <form action="{{ route('invoice.index') }}" method="get">
        <div class="input-group mb-3">
            <input type="text" name="invoice" class="form-control" placeholder="Search here..."
                value="{{ request()->invoice }}">
            <button class="btn btn-dark px-5" id="button-addon2">Search</button>
        </div>
    </form>

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header ">
                    <h2>{{ __('Frontend/frontend.invoices') }}</h2>
                    <a href="{{ route('invoice.index') }}" class="btn btn-primary ml-auto"><i class="fa fa-arrow-left"></i>
                        Back</a>
                </div>
                <div class="table-responsive">
                    <table class="table card-table">
                        <thead>
                            <tr>
                                <th>{{ __('Frontend/frontend.customer_name') }}</th>
                                <th>{{ __('Frontend/frontend.invoice_date') }}</th>
                                <th>{{ __('Frontend/frontend.total_due') }}</th>
                                <th>{{ __('Frontend/frontend.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($invoice->count() > 0)
                                @foreach ($invoice as $item)
                                    <tr>
                                        <td><a
                                                href="{{ route('invoice.show', $item->id) }}">{{ $item->customer_name }}</a>
                                        </td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->total_due }}</td>
                                        <td >
                                            <form action="{{ route('invoice.restore' , $item->id) }}"  method="POST">
                                                @csrf
                                                @method('put')
                                                <button type="submit" class="btn btn-sm btn-outline-info"><i class="fas fa-trash-restore"></i>Restore</button>
                                            </form>
                                        </td>
                                        <td>
                                            {{-- confirm delte --}}
                                            <button class="btn btn-sm btn-outline-danger btn-delete">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                            <form  action="{{ route('invoice.force-delete', $item->id) }}" method="POST">
                                                @csrf
                                                <!-- Form Method Spoofing  -->
                                                @method('delete')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4">
                                    <div class="float-right">
                                        {!! $invoice->links() !!}
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

                <script>
                    $('.btn-delete').on('click', function() {

                        let form = $(this).next('form');
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                            }
                        })
                    });
                </script>
            @endsection
