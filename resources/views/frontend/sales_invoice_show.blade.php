@extends('frontend.layout.master')

@section('user_content')
    <div class="container my-5">
        <div class="d-flex justify-content-between mb-3">
            <h5>Sales Details for {{ $name }} - {{ $phone }} - {{ $address }}</h5>
            <a href="{{route('sales.invoice.list')}}" class="btn btn-sm btn-primary">Back</a>
        </div>
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-primary">
                <tr>
                    <th>SL</th>
                    <th>Date & Time</th>
                    <th>Purpose</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($relatedInvoices as $key => $invoice)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($invoice->created_at)->format('d M Y h:i A') }}</td>
                        <td>{{ $invoice->purpose }}</td>
                        <td>{{ $invoice->amount }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
