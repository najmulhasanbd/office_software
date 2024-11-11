@extends('frontend.layout.master')

@section('user_content')
    <div class="container my-5">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-primary">
                <tr>
                    <th style="width: 10px">SL</th>
                    <th style="width: 100px">Date & Time</th>
                    <th style="width: 10px">Name</th>
                    <th style="width: 10px">Phone</th>
                    <th style="width: 10px">Address</th>
                    <th style="width: 50px">Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($salesInvoice as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y h:i A') }}</td>
                        <td>{{ ucwords($item->name) }}</td>
                        <td>{{ $item->phone }}</td>
                        <td>{{ ucwords($item->address) }}</td>
                        <td>
                            <a href="{{ route('sales.invoice.show', ['name' => $item->name, 'phone' => $item->phone, 'address' => $item->address]) }}"
                                class="btn btn-sm btn-primary">Details</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
