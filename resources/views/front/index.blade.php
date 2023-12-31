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
                    <a href="{{ route('invoice.create') }}" class="btn btn-primary ml-auto"><i class="fa fa-plus"></i>
                        {{ __('Frontend/frontend.create_invoice') }}</a>

                        <a href="{{ route('invoice.trash') }}" class="btn btn-primary ml-auto"><i class="fa fa-trash    "></i>
                            {{ __('Frontend/frontend.trash_invoice') }}</a>
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
                            @foreach ($invoices as $invoice)
                                <tr>
                                    <td><a
                                            href="{{ route('invoice.show', $invoice->id) }}">{{ $invoice->customer_name }}</a>
                                    </td>
                                    <td>{{ $invoice->created_at }}</td>
                                    <td>{{ $invoice->total_due }}</td>
                                    <td>
                                        <a href="{{ route('invoice.edit', $invoice->id) }}"
                                            class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                        {{-- <a href="javascript:void(0)"
                                            onclick="if (confirm('{{ __('Frontend/frontend.r_u_sure') }}')) { document.getElementById('delete-{{ $invoice->id }}').submit(); } else { return false; }"
                                            class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a> --}}
                                        <button class="btn btn-sm btn-danger btn-delete"><i
                                                class="fas fa-trash"></i></button>
                                        <form action="{{ route('invoice.destroy', $invoice->id) }}" method="post"
                                            id="delete-{{ $invoice->id }}" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4">
                                    <div class="float-right">
                                        {!! $invoices->links() !!}
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>


            </div>
        </div>
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
