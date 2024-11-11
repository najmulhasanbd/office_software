@extends('frontend.layout.master')

@section('user_content')
<style>
    tr td{
        vertical-align: middle
    }
</style>
    <div class="purpose_table py-5">
        <div class="container">
            <div class="text-end mb-2">
                <a href="{{ route('user.dashboard') }}" class="btn btn-primary">Back</a>
            </div>
            <div class="row">
                @foreach ($salesData as $date => $data)
                    <div class="d-flex align-items-center justify-content-between">
                        <h5>
                            Sales List ({{ \Carbon\Carbon::parse($date)->format('d F Y') }}):
                        </h5>
                        <p><strong>Total Amount:</strong> ৳ {{ $data['total_amount'] }}</p>
                    </div>
                    <div class="col-12">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th style="width: 10px">SL</th>
                                    <th style="width: 100px">Date & Time</th>
                                    <th style="width: 100px">Name</th>
                                    <th style="width: 100px">Phone</th>
                                    <th style="width: 300px">Purpose</th>
                                    <th style="width: 100px">Amount</th>
                                    <th style="width: 50px">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['sales'] as $key => $sale)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        {{-- <td>{{ \Carbon\Carbon::parse($sale->created_at)->format('d F Y h:i A') }}</td> --}}
                                        <td>{{ \Carbon\Carbon::parse($sale->created_at)->format('d M Y h:i A') }}</td>
                                        <td>{{ ucwords($sale->name) }}</td>
                                        <td>{{ $sale->phone }}</td>
                                        <td>{{ $sale->purpose }}</td>
                                        <td class="d-flex justify-content-between">৳ {{ $sale->amount }}</td>
                                        <td>
                                            @if ($sale->updated_at != $sale->created_at)
                                                <small style="color: gray">Edit by Admin</small>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>


        </div>
    </div>
@endsection
